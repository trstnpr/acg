<?php

if ( class_exists( 'ICWP_WPSF_Processor_Email', false ) ) {
	return;
}

require_once( dirname( __FILE__ ).'/base_wpsf.php' );

class ICWP_WPSF_Processor_Email extends ICWP_WPSF_Processor_BaseWpsf {

	const Slug = 'email';

	protected $m_sRecipientAddress;

	/**
	 * @var string
	 */
	static protected $sModeFile_EmailThrottled;

	/**
	 * @var int
	 */
	static protected $nThrottleInterval = 1;

	/**
	 * @var int
	 */
	protected $nEmailThrottleLimit;

	/**
	 * @var int
	 */
	protected $nEmailThrottleTime;

	/**
	 * @var int
	 */
	protected $nEmailThrottleCount;

	/**
	 * @var boolean
	 */
	protected $bEmailIsThrottled;

	/**
	 * @param ICWP_WPSF_FeatureHandler_Email $oFeatureOptions
	 */
	public function __construct( ICWP_WPSF_FeatureHandler_Email $oFeatureOptions ) {
		parent::__construct( $oFeatureOptions );
	}

	public function init() {
		parent::init();
		self::$sModeFile_EmailThrottled = dirname( __FILE__ ).'/../mode.email_throttled';
	}

	public function run() {
	}

	/**
	 * @return array
	 */
	protected function getEmailHeader() {
		return array(
			_wpsf__( 'Hi !' ),
			'',
		);
	}

	/**
	 * @return array
	 */
	protected function getEmailFooter() {
		$sUrl = array(
			'',
			sprintf( _wpsf__( 'Email sent from the %s Plugin v%s, on %s.' ),
				$this->getController()->getHumanName(),
				$this->getController()->getVersion(),
				$this->loadWp()->getHomeUrl()
			),
			_wpsf__( 'Note: Email delays are caused by website hosting and email providers.' ),
			sprintf( _wpsf__( 'Time Sent: %s' ), $this->loadWp()->getTimeStampForDisplay() )
		);

		return apply_filters( 'icwp_shield_email_footer', $sUrl );
	}

	/**
	 * @param string $sAddress
	 * @param string $sSubject
	 * @param array  $aMessage
	 * @return boolean
	 * @uses wp_mail
	 */
	public function sendEmailTo( $sAddress = '', $sSubject = '', $aMessage = array() ) {

		$this->updateEmailThrottle();
		// We make it appear to have "succeeded" if the throttle is applied.
		if ( $this->bEmailIsThrottled ) {
			return true;
		}

		$aMessage = array_merge( $this->getEmailHeader(), $aMessage, $this->getEmailFooter() );

		$this->emailFilters( true );
		$bSuccess = wp_mail(
			$this->verifyEmailAddress( $sAddress ),
			wp_specialchars_decode( sprintf( '[%s] %s', $this->loadWp()->getSiteName(), $sSubject ) ),
			'<html>'.implode( "<br />", $aMessage ).'</html>'
		);
		$this->emailFilters( false );

		return $bSuccess;
	}

	/**
	 * @param $bAdd - true to add, false to remove
	 */
	protected function emailFilters( $bAdd ) {
		if ( $bAdd ) {
			add_filter( 'wp_mail_from', array( $this, 'setMailFrom' ), 100 );
			add_filter( 'wp_mail_from_name', array( $this, 'setMailFromName' ), 100 );
			add_filter( 'wp_mail_content_type', array( $this, 'setMailContentType' ), 100, 0 );
		}
		else {
			remove_filter( 'wp_mail_from', array( $this, 'setMailFrom' ), 100 );
			remove_filter( 'wp_mail_from_name', array( $this, 'setMailFromName' ), 100 );
			remove_filter( 'wp_mail_content_type', array( $this, 'setMailContentType' ), 100 );
		}
	}

	/**
	 * @return string
	 */
	public function setMailContentType() {
		return 'text/html';
	}

	/**
	 * @param string $sFrom
	 * @return string
	 */
	public function setMailFrom( $sFrom ) {
		$oDP = $this->loadDP();
		$sProposedFrom = apply_filters( 'icwp_shield_from_email', '' );
		if ( $oDP->validEmail( $sProposedFrom ) ) {
			$sFrom = $sProposedFrom;
		}
		// We help out by trying to correct any funky "from" addresses
		// So, at the very least, we don't fail on this for our emails.
		if ( !$oDP->validEmail( $sFrom ) ) {
			$aUrlParts = @parse_url( $this->loadWp()->getWpUrl() );
			if ( !empty( $aUrlParts[ 'host' ] ) ) {
				$sProposedFrom = 'wordpress@'.$aUrlParts[ 'host' ];
				if ( $oDP->validEmail( $sProposedFrom ) ) {
					$sFrom = $sProposedFrom;
				}
			}
		}
		return $sFrom;
	}

	/**
	 * @param string $sFromName
	 * @return string
	 */
	public function setMailFromName( $sFromName ) {
		$sProposedFromName = apply_filters( 'icwp_shield_from_email_name', '' );
		if ( !empty( $sProposedFromName ) ) {
			$sFromName = $sProposedFromName;
		}
		else {
			$sFromName = sprintf( '%s - %s',
				$this->loadWp()->getSiteName(),
				$this->getController()->getHumanName()
			);
		}
		return $sFromName;
	}

	/**
	 * Will send email to the default recipient setup in the object.
	 * @param string $sEmailSubject
	 * @param array  $aMessage
	 * @return boolean
	 */
	public function sendEmail( $sEmailSubject, $aMessage ) {
		return $this->sendEmailTo( null, $sEmailSubject, $aMessage );
	}

	/**
	 * Whether we're throttled is dependent on 2 signals.  The time interval has changed, or the there's a file
	 * system object telling us we're throttled.
	 * The file system object takes precedence.
	 * @return boolean
	 */
	protected function updateEmailThrottle() {

		// Throttling Is Effectively Off
		if ( $this->getThrottleLimit() <= 0 ) {
			$this->setThrottledFile( false );
			return $this->bEmailIsThrottled;
		}

		// Check that there is an email throttle file. If it exists and its modified time is greater than the 
		// current $this->m_nEmailThrottleTime it suggests another process has touched the file and updated it
		// concurrently. So, we update our $this->m_nEmailThrottleTime accordingly.
		if ( is_file( self::$sModeFile_EmailThrottled ) ) {
			$nModifiedTime = filemtime( self::$sModeFile_EmailThrottled );
			if ( $nModifiedTime > $this->nEmailThrottleTime ) {
				$this->nEmailThrottleTime = $nModifiedTime;
			}
		}

		if ( !isset( $this->nEmailThrottleTime ) || $this->nEmailThrottleTime > $this->time() ) {
			$this->nEmailThrottleTime = $this->time();
		}
		if ( !isset( $this->nEmailThrottleCount ) ) {
			$this->nEmailThrottleCount = 0;
		}

		// If $nNow is greater than throttle interval (1s) we turn off the file throttle and reset the count
		$nDiff = $this->time() - $this->nEmailThrottleTime;
		if ( $nDiff > self::$nThrottleInterval ) {
			$this->nEmailThrottleTime = $this->time();
			$this->nEmailThrottleCount = 1;    //we set to 1 assuming that this was called because we're about to send, or have just sent, an email.
			$this->setThrottledFile( false );
		}
		else if ( is_file( self::$sModeFile_EmailThrottled ) || ( $this->nEmailThrottleCount >= $this->getThrottleLimit() ) ) {
			$this->setThrottledFile( true );
		}
		else {
			$this->nEmailThrottleCount++;
		}
	}

	public function setThrottledFile( $infOn = false ) {

		$this->bEmailIsThrottled = $infOn;

		if ( $infOn && !is_file( self::$sModeFile_EmailThrottled ) && function_exists( 'touch' ) ) {
			@touch( self::$sModeFile_EmailThrottled );
		}
		else if ( !$infOn && is_file( self::$sModeFile_EmailThrottled ) ) {
			@unlink( self::$sModeFile_EmailThrottled );
		}
	}

	public function setDefaultRecipientAddress( $insEmailAddress ) {
		$this->m_sRecipientAddress = $insEmailAddress;
	}

	/**
	 * @param string $sEmailAddress
	 * @return string
	 */
	public function verifyEmailAddress( $sEmailAddress = '' ) {
		return $this->loadDP()
					->validEmail( $sEmailAddress ) ? $sEmailAddress : $this->getPluginDefaultRecipientAddress();
	}

	public function getThrottleLimit() {
		if ( empty( $this->nEmailThrottleLimit ) ) {
			$this->nEmailThrottleLimit = $this->getOption( 'send_email_throttle_limit' );
		}
		return $this->nEmailThrottleLimit;
	}
}