<?php
/**
 * Quick and dirty SocketWrapper, incomplete but usable currently tcp only
 * Author : Mizno Kruge
 * Copyright Tricipta Media Perkasa
 */
class SocketWrapper
{
	protected $_config = array();
	protected $_socket;
	public $last_err_msg;

	public function __construct(array $_config)
	{
		$this->_config['host'] = isset( $_config['host'] ) ? $_config['host'] : '127.0.0.1';
		$this->_config['port'] = isset( $_config['port'] ) ? $_config['port'] : '9090';

		$this->_socket = socket_create(
            AF_INET, SOCK_STREAM, SOL_TCP
            );

	}

	public function connect()
	{
		return socket_connect($this->_socket,gethostbyname($this->_config['host']),$this->_config['port']);
	}

	public function disconnect()
	{
		socket_close($this->_socket);
	}

	public function write($msg)
	{
		print_r($msg);
		socket_write( $this->_socket, $msg, strlen($msg) );
	}

	public function flush()
	{
		fflush($this->_socket);
	}

	public function getSocket()
	{
		return $this->_socket;
	}

	public function checkError()
	{
		$errCode = socket_last_error($this->_socket) ;
		if( $errCode != 0)
		{
			$this->last_err_msg = socket_strerror($errCode);
			socket_clear_error();
			return $errCode;
		}

		return TRUE;
	}

	function __destruct()
	{
		@socket_close($this->_socket);
	}
}