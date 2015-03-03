<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Devuelve la letra que le corresponde al NIF a un DNI
 * @param string $dni
 */
function dni_LetraNIF($dni)
{
	return mb_substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($dni, 0, 8) % 23, 1);
}

function dni_DNIConLetra($dni)
{
	$letra = dni_LetraNIF($dni);
	
	return $dni . $letra;
}