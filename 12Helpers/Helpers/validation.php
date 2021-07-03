<?php
// Apenas PHP. Nanhuma biblioteca do Laravel

/*  CHECK IF A $STRING IS INT. */
function isNumeric($string){
	if (!filter_var($string, FILTER_VALIDATE_INT)) 
        return false;
    else
        return true;
}

/*  CHECK IF A $STRING IS FLOAT. */
function isFloat($string){
	if (!filter_var($string, FILTER_VALIDATE_FLOAT)) 
        return false;
    else
        return true;
}

/*  CHECK IF A $STRING IS BOOLEAN. */
function isBoolean($string){
	if (!filter_var($string, FILTER_VALIDATE_BOOLEAN)) 
        return false;
    else
        return true;
}

/* CHECK IF A VALID IP */
function isValidIP($string) {
    if (!filter_var($string, FILTER_VALIDATE_IP)) 
        return false;
    else
        return true;
}

/*  CHECK IF A VALID URL */
function isValidUrl($string) {
    if (!filter_var($string, FILTER_VALIDATE_URL)) 
        return false;
    else
        return true;
}

/*  CHECK IF A VALID EMAIL */
function isValidEmail($string) {
    if (!filter_var($string, FILTER_VALIDATE_EMAIL)) 
        return false;
    else
        return true;
}

/*  CHECK IF A $STRING IS EQUAL TO OTHER */
function isEqual($string1, $string2){
    if ($string2 != $string1)
        return false;
    else
        return true;
}

/*  CHECK IF A $STRING IS VALIDATE NAMES WITHOUT NUMBERS BUT WITH ~, ^. */
function isValidName($string){
    if (!preg_match('/^[A-ZÀ-Ÿ][A-zÀ-ÿ\'.]+\s([A-zÀ-ÿ\'.]\s?)*[A-ZÀ-Ÿ.][A-zÀ-ÿ\'.]+$/', $string))
        return false;
    else
        return true;
}

/*  CHECK IF A $STRING IS CPF OF CPNJ WITH OR WITHOUT PONTUATION */
function isValidCPForCNPJ($string){
    if (!preg_match('/^([0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}|[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2})$/', $string))
        return false;
    else
        return true;
}

/*  CHECK IF A $STRING IS CPF OF CPNJ WITH OR WITHOUT PONTUATION */
function isValidChave($string){
  if (!preg_match('/^([0-9]{4}\-[0-9]{4}\-[0-9]{4}\-[0-9]{4})$/', $string))
    return false;
  else
    return true;
}

/*  CHECK IF A $STRING IS A DATE 2020-11-03 */
function isDateStd($string){
    if (!preg_match('/^([0-9]{4}-[0-9]{2}-[0-9]{2})$/', $string))
      return false;
    else
      return true;
}

/*  CHECK IF A $STRING IS A DATE 03/06/1989 */
function isDate($string){
    if (!preg_match('/^([0-9]{2}\/[0-9]{2}\/[0-9]{4})$/', $string))
      return false;
    else
      return true;
}

function isCPForCNPJ($string){
    $string = preg_replace('/[^0-9]/', '', $valor);
    if (strlen($string) == 11)
    {
        $result->cpf = $valor;
    }
    elseif (strlen($string) == 14)
    {
        $result->cnpj = $valor;
    }
}

