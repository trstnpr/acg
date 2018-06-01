<?php

if ( class_exists( 'ICWP_WPSF_Processor_CronBase' ) ) {
	return;
}

require_once( dirname( __FILE__ ).'/base_wpsf.php' );

abstract class ICWP_WPSF_Processor_CronBase extends ICWP_WPSF_Processor_BaseWpsf {

	/**
	 */
	public function run() {
		$this->setupCron();
	}

	protected function setupCron() {
		try {
			$this->loadWpCronProcessor()
				 ->setRecurrence( $this->getCronRecurrence() )
				 ->createCronJob(
					 $this->getCronName(),
					 $this->getCronCallback()
				 );
		}
		catch ( Exception $oE ) {
		}
		add_action( $this->prefix( 'delete_plugin' ), array( $this, 'deleteCron' ) );
	}

	/**
	 * @return string
	 */
	protected function getCronRecurrence() {
		return $this->prefix( sprintf( 'per-day-%s', $this->getCronFrequency() ) );
	}

	/**
	 * @return callable
	 */
	abstract protected function getCronCallback();

	/**
	 * @return int
	 */
	abstract protected function getCronFrequency();

	/**
	 * @return string
	 */
	abstract protected function getCronName();

	/**
	 */
	public function deleteCron() {
		$this->loadWpCronProcessor()->deleteCronJob( $this->getCronName() );
	}
}