<?php

if ( class_exists( 'ICWP_WPSF_FeatureHandler_AdminAccessRestriction' ) ) {
	return;
}

require_once( dirname( __FILE__ ).'/base_wpsf.php' );

class ICWP_WPSF_FeatureHandler_AdminAccessRestriction extends ICWP_WPSF_FeatureHandler_BaseWpsf {

	private $bHasPermissionToSubmit;

	/**
	 * @return bool
	 */
	protected function isReadyToExecute() {
		return parent::isReadyToExecute() && $this->hasAccessKey() && !$this->isVisitorWhitelisted();
	}

	/**
	 * @param array $aAjaxResponse
	 * @return array
	 */
	public function handleAuthAjax( $aAjaxResponse ) {

		if ( empty( $aAjaxResponse ) ) {
			switch ( $this->loadDP()->request( 'exec' ) ) {

				case 'sec_admin_login':
				case 'restricted_access':
					$aAjaxResponse = $this->ajaxExec_SecAdminLogin();
					break;

				case 'sec_admin_login_box':
					$aAjaxResponse = $this->ajaxExec_SecAdminLoginBox();
					break;

					break;

				default:
					break;
			}
		}
		return parent::handleAuthAjax( $aAjaxResponse );
	}

	/**
	 * @return array
	 */
	protected function ajaxExec_SecAdminLogin() {
		$aResponse = array();

		if ( $this->checkAdminAccessKeySubmission() ) {

			if ( $this->setPermissionToSubmit( true ) ) {
				$aResponse[ 'success' ] = true;
				$aResponse[ 'html' ] = _wpsf__( 'Security Admin Access Key Accepted.' )
									   .' '._wpsf__( 'Please wait' ).' ...';
			}
			else {
				$aResponse[ 'html' ] = _wpsf__( 'Failed to process key - you may need to re-login to WordPress.' );
			}
		}
		else {
			$aResponse[ 'html' ] = $this->renderAdminAccessAjaxLoginForm( _wpsf__( 'Error - Invalid Key' ) );
		}

		return $aResponse;
	}

	/**
	 * @return array
	 */
	protected function ajaxExec_SecAdminLoginBox() {
		return array(
			'success' => 'true',
			'html'    => $this->renderAdminAccessAjaxLoginForm()
		);
	}

	/**
	 * @return array
	 */
	protected function ajaxExec_RestrictedAccess() {
		$aResponse = array();

		if ( $this->checkAdminAccessKeySubmission() ) {

			if ( $this->setPermissionToSubmit( true ) ) {
				$aResponse[ 'success' ] = true;
				$aResponse[ 'html' ] = _wpsf__( 'Security Admin Access Key Accepted.' )
									   .' '._wpsf__( 'Please wait' ).' ...';
			}
			else {
				$aResponse[ 'html' ] = _wpsf__( 'Failed to process key - you may need to re-login to WordPress.' );
			}
		}
		else {
			$aResponse[ 'html' ] = $this->renderAdminAccessAjaxLoginForm( _wpsf__( 'Error - Invalid Key' ) );
		}

		return $aResponse;
	}

	/**
	 * @param string $sMessage
	 * @return string
	 */
	protected function renderAdminAccessAjaxLoginForm( $sMessage = '' ) {

		$aData = array(
			'ajax'    => array(
				'sec_admin_login' => json_encode( $this->getSecAdminLoginAjaxData() )
			),
			'strings' => array(
				'access_message' => empty( $sMessage ) ? _wpsf__( 'Enter your Security Admin Access Key' ) : $sMessage
			)
		);
		return $this->renderTemplate( 'snippets/admin_access_login', $aData );
	}

	/**
	 * @param bool $bHasPermission
	 * @return bool
	 */
	public function doCheckHasPermissionToSubmit( $bHasPermission = true ) {

		$this->bHasPermissionToSubmit = $bHasPermission;
		if ( $this->isModuleEnabled() ) {
			$sAccessKey = $this->getAccessKeyHash();
			if ( !empty( $sAccessKey ) ) {
				$this->bHasPermissionToSubmit = $this->isSecAdminSessionValid() || $this->checkAdminAccessKeySubmission();
			}
		}
		return $this->bHasPermissionToSubmit;
	}

	/**
	 * @return string
	 */
	protected function getAccessKeyHash() {
		return $this->getOpt( 'admin_access_key' );
	}

	/** TODO
	 * @return bool
	 */
	public function getAdminAccessArea_Options() {
		return $this->getOptIs( 'admin_access_restrict_options', 'Y' );
	}

	/**
	 * @return array
	 */
	public function getAdminAccessArea_Plugins() {
		return $this->getAdminAccessArea( 'plugins' );
	}

	/**
	 * @return array
	 */
	public function getAdminAccessArea_Themes() {
		return $this->getAdminAccessArea( 'themes' );
	}

	/**
	 * @return array
	 */
	public function getAdminAccessArea_Posts() {
		return $this->getAdminAccessArea( 'posts' );
	}

	/**
	 * @param string $sArea one of plugins, themes
	 * @return array
	 */
	public function getAdminAccessArea( $sArea = 'plugins' ) {
		$aSettings = $this->getOpt( 'admin_access_restrict_'.$sArea, array() );
		return !is_array( $aSettings ) ? array() : $aSettings;
	}

	/**
	 * @return array
	 */
	public function getRestrictedOptions() {
		$aOptions = $this->getDef( 'admin_access_options_to_restrict' );
		return is_array( $aOptions ) ? $aOptions : array();
	}

	/**
	 * TODO: Bug where if $sType is defined, it'll be set to 'wp' anyway
	 * @param string $sType - wp or wpms
	 * @return array
	 */
	public function getOptionsToRestrict( $sType = '' ) {
		$sType = empty( $sType ) ? ( $this->loadWp()->isMultisite() ? 'wpms' : 'wp' ) : 'wp';
		$aOptions = $this->getRestrictedOptions();
		return ( isset( $aOptions[ $sType.'_options' ] ) && is_array( $aOptions[ $sType.'_options' ] ) ) ? $aOptions[ $sType.'_options' ] : array();
	}

	/**
	 * @param string $sType - wp or wpms
	 * @return array
	 */
	public function getOptionsPagesToRestrict( $sType = '' ) {
		$sType = empty( $sType ) ? ( $this->loadWp()->isMultisite() ? 'wpms' : 'wp' ) : 'wp';
		$aOptions = $this->getRestrictedOptions();
		return ( isset( $aOptions[ $sType.'_pages' ] ) && is_array( $aOptions[ $sType.'_pages' ] ) ) ? $aOptions[ $sType.'_pages' ] : array();
	}

	/**
	 * @return bool
	 */
	public function hasAccessKey() {
		$sKey = $this->getAccessKeyHash();
		return !empty( $sKey ) && strlen( $sKey ) == 32;
	}

	/**
	 * @return bool
	 */
	protected function startSecurityAdmin() {
		return $this->getSessionsProcessor()
					->getSessionUpdater()
					->startSecurityAdmin( $this->getSession() );
	}

	/**
	 */
	protected function terminateSecurityAdmin() {
		return $this->getSessionsProcessor()
					->getSessionUpdater()
					->terminateSecurityAdmin( $this->getSession() );
	}

	/**
	 */
	protected function doExtraSubmitProcessing() {
		// We should only use setPermissionToSubmit() here, before any headers elsewhere are sent out.
		if ( $this->isAccessKeyRequest() ) {
			if ( $this->checkAdminAccessKeySubmission() ) {
				$this->setPermissionToSubmit( true );
			}
		}
	}

	protected function setSaveUserResponse() {
		if ( $this->isAccessKeyRequest() ) {
			$bSuccess = $this->doCheckHasPermissionToSubmit();
			if ( $bSuccess ) {
				$sMessage = sprintf( _wpsf__( '%s Security Admin key accepted.' ), self::getConn()->getHumanName() );
			}
			else {
				$sMessage = sprintf( _wpsf__( '%s Security Admin key not accepted.' ), self::getConn()
																						   ->getHumanName() );
			}
			$this->loadAdminNoticesProcessor()
				 ->addFlashMessage( $sMessage, $bSuccess ? 'updated' : 'error' );
		}
		else {
			parent::setSaveUserResponse();
		}
	}

	/**
	 * @return bool
	 */
	protected function isSecAdminSessionValid() {
		$bValid = false;
		if ( $this->hasSession() ) {
			$nStartedAt = $this->getSession()->getSecAdminAt();
			$bValid = ( $this->loadDP()->time() - $nStartedAt ) < $this->getOpt( 'admin_access_timeout' )*60;
		}
		return $bValid;
	}

	/**
	 * @param bool $fPermission
	 * @return bool
	 */
	public function setPermissionToSubmit( $fPermission = false ) {
		return $fPermission ? $this->startSecurityAdmin() : $this->terminateSecurityAdmin();
	}

	/**
	 * @return bool
	 */
	protected function checkAdminAccessKeySubmission() {
		$sAccessKeyRequest = $this->loadDP()->post( 'admin_access_key_request', '' );
		$bSuccess = $this->verifyAccessKey( $sAccessKeyRequest );
		if ( !$bSuccess && !empty( $sAccessKeyRequest ) ) {
			add_filter( $this->prefix( 'ip_black_mark' ), '__return_true' );
		}
		return $bSuccess;
	}

	/**
	 * @return bool
	 */
	protected function isAccessKeyRequest() {
		return strlen( $this->loadDP()->post( 'admin_access_key_request', '' ) ) > 0;
	}

	/**
	 * @param string $sKey
	 * @return bool
	 */
	public function verifyAccessKey( $sKey ) {
		return !empty( $sKey ) && ( $this->getAccessKeyHash() === md5( $sKey ) );
	}

	/**
	 * @return array
	 */
	public function getWhitelabelOptions() {
		$sMain = $this->getOpt( 'wl_namemain' );
		$sMenu = $this->getOpt( 'wl_namemenu' );
		if ( empty( $sMenu ) ) {
			$sMenu = $sMain;
		}

		return array(
			'name_main'   => $sMain,
			'name_menu'   => $sMenu,
			'description' => $this->getOpt( 'wl_description' ),
			'url_home'    => $this->getOpt( 'wl_homeurl' ),
			'url_icon'    => $this->getOpt( 'wl_iconurl' ),
		);
	}

	/**
	 * @return bool
	 */
	public function isWlEnabled() {
		return $this->getOptIs( 'whitelabel_enable', 'Y' ) && $this->isPremium();
	}

	/**
	 * @return bool
	 */
	public function isWlHideUpdates() {
		return $this->isWlEnabled() && $this->getOptIs( 'wl_hide_updates', 'Y' );
	}

	/**
	 * @param string $sKey
	 * @return $this
	 * @throws Exception
	 */
	public function setNewAccessKeyManually( $sKey ) {
		if ( !$this->doCheckHasPermissionToSubmit() ) {
			throw new Exception( 'User does not have permission to update the Security Admin Access Key.' );
		}
		if ( empty( $sKey ) ) {
			throw new Exception( 'Attempting to set an empty Security Admin Access Key.' );
		}

		$this->setIsMainFeatureEnabled( true )
			 ->setOpt( 'admin_access_key', md5( $sKey ) )
			 ->savePluginOptions();
		return $this;
	}

	/**
	 * @param array $aAllNotices
	 * @return array
	 */
	public function addInsightsNoticeData( $aAllNotices ) {

		$aNotices = array(
			'title'    => _wpsf__( 'Security Admin Protection' ),
			'messages' => array()
		);

		{//sec admin
			if ( !( $this->isModuleEnabled() && $this->hasAccessKey() ) ) {
				$aNotices[ 'messages' ][ 'sec_admin' ] = array(
					'title'   => 'Security Plugin Unprotected',
					'message' => sprintf(
						_wpsf__( "The Security Admin protection is not active." ),
						$this->getConn()->getHumanName()
					),
					'href'    => $this->getUrl_AdminPage(),
					'action'  => sprintf( 'Go To %s', _wpsf__( 'Options' ) ),
					'rec'     => _wpsf__( 'Security Admin should be turned-on to protect your security settings.' )
				);
			}
		}

		$aNotices[ 'count' ] = count( $aNotices[ 'messages' ] );
		$aAllNotices[ 'sec_admin' ] = $aNotices;

		return $aAllNotices;
	}

	/**
	 * @param array $aOptionsParams
	 * @return array
	 * @throws Exception
	 */
	protected function loadStrings_SectionTitles( $aOptionsParams ) {

		$sSectionSlug = $aOptionsParams[ 'slug' ];
		switch ( $sSectionSlug ) {

			case 'section_enable_plugin_feature_admin_access_restriction' :
				$sTitle = sprintf( _wpsf__( 'Enable Module: %s' ), $this->getMainFeatureName() );
				$aSummary = array(
					sprintf( _wpsf__( 'Purpose - %s' ), _wpsf__( 'Restricts access to this plugin preventing unauthorized changes to your security settings.' ) ),
					sprintf( _wpsf__( 'Recommendation - %s' ), sprintf( _wpsf__( 'Keep the %s feature turned on.' ), _wpsf__( 'Security Admin' ) ) ),
					sprintf( _wpsf__( 'You need to also enter a new Access Key to enable this feature.' ) ),
				);
				$sTitleShort = sprintf( _wpsf__( '%s/%s Module' ), _wpsf__( 'Enable' ), _wpsf__( 'Disable' ) );
				break;

			case 'section_admin_access_restriction_settings' :
				$sTitle = _wpsf__( 'Security Admin Restriction Settings' );
				$aSummary = array(
					sprintf( _wpsf__( 'Purpose - %s' ), _wpsf__( 'Restricts access to this plugin preventing unauthorized changes to your security settings.' ) ),
					sprintf( _wpsf__( 'Recommendation - %s' ), _wpsf__( 'Use of this feature is highly recommend.' ) ),
				);
				$sTitleShort = _wpsf__( 'Security Admin Settings' );
				break;

			case 'section_admin_access_restriction_areas' :
				$sTitle = _wpsf__( 'Security Admin Restriction Zones' );
				$aSummary = array(
					sprintf( _wpsf__( 'Purpose - %s' ), _wpsf__( 'Restricts access to key WordPress areas for all users not authenticated with the Security Admin Access system.' ) ),
					sprintf( _wpsf__( 'Recommendation - %s' ), _wpsf__( 'Use of this feature is highly recommend.' ) ),
				);
				$sTitleShort = _wpsf__( 'Access Restriction Zones' );
				break;

			case 'section_whitelabel' :
				$sTitle = _wpsf__( 'Shield White Label' );
				$aSummary = array(
					sprintf( _wpsf__( 'Purpose - %s' ),
						sprintf( _wpsf__( 'Rename and re-brand the %s plugin for your client site installations.' ),
							$this->getConn()->getHumanName() ) ),
				);
				$sTitleShort = _wpsf__( 'White Label' );
				break;

			default:
				throw new Exception( sprintf( 'A section slug was defined but with no associated strings. Slug: "%s".', $sSectionSlug ) );
		}
		$aOptionsParams[ 'title' ] = $sTitle;
		$aOptionsParams[ 'summary' ] = ( isset( $aSummary ) && is_array( $aSummary ) ) ? $aSummary : array();
		$aOptionsParams[ 'title_short' ] = $sTitleShort;
		return $aOptionsParams;
	}

	/**
	 * @param array $aOptionsParams
	 * @return array
	 * @throws Exception
	 */
	protected function loadStrings_Options( $aOptionsParams ) {

		$sKey = $aOptionsParams[ 'key' ];
		switch ( $sKey ) {

			case 'enable_admin_access_restriction' :
				$sName = sprintf( _wpsf__( 'Enable %s Module' ), _wpsf__( 'Security Admin' ) );
				$sSummary = _wpsf__( 'Enforce Security Admin Access Restriction' );
				$sDescription = _wpsf__( 'Enable this with great care and consideration. Ensure that you set a key that you have set an access key that you will remember.' );
				break;

			case 'admin_access_key' :
				$sName = _wpsf__( 'Security Admin Access Key' );
				$sSummary = _wpsf__( 'Provide/Update Security Admin Access Key' );
				$sDescription = sprintf( _wpsf__( 'Careful: %s' ), _wpsf__( 'If you forget this, you could potentially lock yourself out from using this plugin.' ) )
								.'<br/><strong>'.( $this->hasAccessKey() ? _wpsf__( 'Security Key Currently Set' ) : _wpsf__( 'Security Key NOT Currently Set' ) ).'</strong>';
				break;

			case 'admin_access_timeout' :
				$sName = _wpsf__( 'Security Admin Timeout' );
				$sSummary = _wpsf__( 'Specify An Automatic Timeout Interval For Security Admin Access' );
				$sDescription = _wpsf__( 'This will automatically expire your Security Admin Session.' )
								.'<br />'.sprintf( _wpsf__( 'Default: %s minutes.' ), $this->getOptionsVo()
																						   ->getOptDefault( 'admin_access_timeout' ) );
				break;

			case 'admin_access_restrict_posts' :
				$sName = _wpsf__( 'Pages' );
				$sSummary = _wpsf__( 'Restrict Access To Key WordPress Posts And Pages Actions' );
				$sDescription = sprintf( _wpsf__( 'Careful: %s' ), _wpsf__( 'This will restrict access to page/post creation, editing and deletion.' ) )
								.'<br />'.sprintf( _wpsf__( 'Note: %s' ), sprintf( _wpsf__( 'Selecting "%s" will also restrict all other options.' ), _wpsf__( 'Edit' ) ) );
				break;

			case 'admin_access_restrict_plugins' :
				$sName = _wpsf__( 'Plugins' );
				$sSummary = _wpsf__( 'Restrict Access To Key WordPress Plugin Actions' );
				$sDescription = sprintf( _wpsf__( 'Careful: %s' ), _wpsf__( 'This will restrict access to plugin installation, update, activation and deletion.' ) )
								.'<br />'.sprintf( _wpsf__( 'Note: %s' ), sprintf( _wpsf__( 'Selecting "%s" will also restrict all other options.' ), _wpsf__( 'Activate' ) ) );
				break;

			case 'admin_access_restrict_options' :
				$sName = _wpsf__( 'WordPress Options' );
				$sSummary = _wpsf__( 'Restrict Access To Certain WordPress Admin Options' );
				$sDescription = sprintf( _wpsf__( 'Careful: %s' ), _wpsf__( 'This will restrict the ability of WordPress administrators from changing key WordPress settings.' ) );
				break;

			case 'admin_access_restrict_admin_users' :
				$sName = _wpsf__( 'Admin Users' );
				$sSummary = _wpsf__( 'Restrict Access To Create/Delete/Modify Other Admin Users' );
				$sDescription = sprintf( _wpsf__( 'Careful: %s' ), _wpsf__( 'This will restrict the ability of WordPress administrators from creating, modifying or promoting other administrators.' ) );
				break;

			case 'admin_access_restrict_themes' :
				$sName = _wpsf__( 'Themes' );
				$sSummary = _wpsf__( 'Restrict Access To WordPress Theme Actions' );
				$sDescription = sprintf( _wpsf__( 'Careful: %s' ), _wpsf__( 'This will restrict access to theme installation, update, activation and deletion.' ) )
								.'<br />'.
								sprintf(
									_wpsf__( 'Note: %s' ),
									sprintf(
										_wpsf__( 'Selecting "%s" will also restrict all other options.' ),
										sprintf(
											_wpsf__( '%s and %s' ),
											_wpsf__( 'Activate' ),
											_wpsf__( 'Edit Theme Options' )
										)
									)
								);
				break;

			case 'whitelabel_enable' :
				$sName = sprintf( '%s: %s', _wpsf__( 'Enable' ), _wpsf__( 'White Label' ) );
				$sSummary = _wpsf__( 'Activate Your White Label Settings' );
				$sDescription = _wpsf__( 'Turn on/off the application of your White Label settings.' );
				break;
			case 'wl_hide_updates' :
				$sName = _wpsf__( 'Hide Updates' );
				$sSummary = _wpsf__( 'Hide Plugin Updates From Non-Security Admins' );
				$sDescription = _wpsf__( 'Do not show the availability of updates to non-security administrators.' );
				break;
			case 'wl_namemain' :
				$sName = _wpsf__( 'Plugin Name' );
				$sSummary = _wpsf__( 'The Name Of The Plugin' );
				$sDescription = _wpsf__( 'The name of the plugin that will be displayed to your site users.' );
				break;
			case 'wl_namemenu' :
				$sName = _wpsf__( 'Menu Title' );
				$sSummary = _wpsf__( 'The Main Menu Title Of The Plugin' );
				$sDescription = sprintf( _wpsf__( 'The Main Menu Title Of The Plugin. If left empty, the "%s" will be used.' ), _wpsf__( 'Plugin Name' ) );
				break;
			case 'wl_description' :
				$sName = _wpsf__( 'Description' );
				$sSummary = _wpsf__( 'The Description Of The Plugin' );
				$sDescription = _wpsf__( 'The description of the plugin displayed on the plugins page.' );
				break;
			case 'wl_homeurl' :
				$sName = _wpsf__( 'Home URL' );
				$sSummary = _wpsf__( 'Plugin Home Page URL' );
				$sDescription = _wpsf__( "When a user clicks the home link for this plugin, this is where they'll be directed." );
				break;
			case 'wl_iconurl' :
				$sName = _wpsf__( 'Icon URL' );
				$sSummary = _wpsf__( 'Plugin Icon URL' );
				$sDescription = _wpsf__( 'The URL of the icon displayed in the menu and in the admin pages.' );
				break;

			default:
				throw new Exception( sprintf( 'An option has been defined but without strings assigned to it. Option key: "%s".', $sKey ) );
		}

		$aOptionsParams[ 'name' ] = $sName;
		$aOptionsParams[ 'summary' ] = $sSummary;
		$aOptionsParams[ 'description' ] = $sDescription;
		return $aOptionsParams;
	}

	/**
	 * This is the point where you would want to do any options verification
	 */
	protected function doPrePluginOptionsSave() {

		if ( $this->getOpt( 'admin_access_timeout' ) < 1 ) {
			$this->getOptionsVo()->resetOptToDefault( 'admin_access_timeout' );
		}

		// Restricting Activate Plugins also means restricting the rest.
		$aPluginsRestrictions = $this->getAdminAccessArea_Plugins();
		if ( in_array( 'activate_plugins', $aPluginsRestrictions ) ) {
			$this->setOpt(
				'admin_access_restrict_plugins',
				array_unique( array_merge( $aPluginsRestrictions, array(
					'install_plugins',
					'update_plugins',
					'delete_plugins'
				) ) )
			);
		}

		// Restricting Switch (Activate) Themes also means restricting the rest.
		$aThemesRestrictions = $this->getAdminAccessArea_Themes();
		if ( in_array( 'switch_themes', $aThemesRestrictions ) && in_array( 'edit_theme_options', $aThemesRestrictions ) ) {
			$this->setOpt(
				'admin_access_restrict_themes',
				array_unique( array_merge( $aThemesRestrictions, array(
					'install_themes',
					'update_themes',
					'delete_themes'
				) ) )
			);
		}

		$aPostRestrictions = $this->getAdminAccessArea_Posts();
		if ( in_array( 'edit', $aPostRestrictions ) ) {
			$this->setOpt(
				'admin_access_restrict_posts',
				array_unique( array_merge( $aPostRestrictions, array( 'create', 'publish', 'delete' ) ) )
			);
		}
	}
}