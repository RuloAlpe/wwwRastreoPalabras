<?php

namespace app\modules\ModUsuarios\models;

use Yii;

class Utils {
	
	/**
	 * Obtenemos la fecha actual para almacenarla
	 *
	 * @return string
	 */
	public static function getFechaActual() {
		
		// Inicializamos la fecha y hora actual
		$fecha = date ( 'Y-m-d H:i:s', time () );
		return $fecha;
	}
	
	/**
	 * Genera un token para guardarlo en la base de datos
	 *
	 * @param string $pre        	
	 * @return string
	 */
	public static function generateToken($pre = 'tok') {
		$token = $pre . md5 ( uniqid ( $pre ) ) . uniqid ();
		return $token;
	}
	
	/**
	 * Obtiene fecha de vencimiento para una fecha
	 * @param unknown $fechaActualTimestamp
	 */
	public static function getFechaVencimiento($fechaActualTimestamp) {
		$date = date ( 'Y-m-d H:i:s', strtotime ( "+".Yii::$app->params ['modUsuarios'] ['recueperarPass'] ['diasValidos']." day", strtotime ( $fechaActualTimestamp ) ) );
	
		return $date;
	}
	
	/**
	 * Envia el correo electronico para la activiación de la cuenta
	 *
	 * @param array $parametrosEmail
	 * @return boolean        	
	 */
	public function sendEmailActivacion($email,$parametrosEmail) {
		
		// Envia el correo electronico
		return $this->sendEmail ( '@app/modules/ModUsuarios/email/activarCuenta', '@app/modules/ModUsuarios/email/layouts/text', Yii::$app->params ['modUsuarios'] ['email'] ['emailActivacion'],$email, Yii::$app->params ['modUsuarios'] ['email'] ['subjectActivacion'], $parametrosEmail );
	}
	
	/**
	 * Envia el correo electronico para recuperar el correo electronico
	 *
	 * @param array $parametrosEmail
	 * @return boolean
	 */
	public  function sendEmailRecuperarPassword($email,$parametrosEmail) {
		// Envia el correo electronico
		return $this->sendEmail ( '@app/modules/ModUsuarios/email/recuperarPassword', '@app/modules/ModUsuarios/email/layouts/text', Yii::$app->params ['modUsuarios'] ['email'] ['emailRecuperarPass'], $email, Yii::$app->params ['modUsuarios'] ['email'] ['subjectRecuperarPass'], $parametrosEmail );
	}
	
	/**
	 * Envia mensaje de correo electronico
	 *
	 * @param string $templateHtml        	
	 * @param string $templateText        	
	 * @param string $from        	
	 * @param string $to        	
	 * @param string $subject        	
	 * @param array $params        	
	 * @return boolean
	 */
	private function sendEmail($templateHtml, $templateText, $from, $to, $subject, $params) {
		return Yii::$app->mailer->compose ( [
				// 'html' => '@app/mail/layouts/example',
				// 'text' => '@app/mail/layouts/text'
				'html' => $templateHtml,
				//'text' => $templateText 
		], $params )->setFrom ( $from )->setTo ( $to )->setSubject ( $subject )->send ();
	}
}