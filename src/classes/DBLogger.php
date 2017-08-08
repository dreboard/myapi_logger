<?php
namespace MyApiCore\System;

use MySQLHandler\MySQLHandler;
use Monolog\Logger as Logger;
/**
 * Class DBLogger
 * Use Monolog MySQLHandler to handle database logging
 *
 * @package Design_Patterns\Strategy
 */
class DBLogger extends BaseModel implements ILogger {

	/**
	 * @var $logger
	 */
	protected $logger;

	/**
	 * DBLogger constructor.
	 */
	public function __construct() {
		parent::__construct();
		$mySQLHandler = new MySQLHandler($this->db, "logs");
		$this->logger = new Logger('db_logger');
		$this->logger->pushHandler($mySQLHandler);
	}

	/**
	 * Send logging message to db
	 *
	 * @param string $data
	 * @return mixed|void
	 */
	public function log( string $data ) {
		try {
			$this->logger->warning( $data );
		} catch ( \Throwable $e ) {
			$this->logger->error( $e->getMessage() );
		}
	}
}