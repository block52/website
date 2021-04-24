<?php
namespace phpformbuilder\Validator;

/**
 * Form validation library.
 *
 * @author Tasos Bekos <tbekos@gmail.com>
 * @author Chris Gutierrez <cdotgutierrez@gmail.com>
 * @author Corey Ballou <ballouc@gmail.com>
 * @see https://github.com/blackbelt/php-validation
 * @see Based on idea: http://brettic.us/2010/06/18/form-validation-class-using-php-5-3/
 */
class Validator
{
    protected $messages = array();
    protected $errors = array();
    protected $rules = array();
    protected $fields = array();
    protected $functions = array();
    protected $arguments = array();
    protected $filters = array();
    protected $data = null;
    protected $validData = array();

    /**
     * Constructor.
     * Define values to validate.
     *
     * @param array $data
     */
    public function __construct(array $data = null, $language = 'en')
    {
        $this->language = $language;
        if (!empty($data)) {
            $this->setData($data);
        }
    }

    /**
     * set the data to be validated
     *
     * @access public
     * @param  mixed         $data
     * @return FormValidator
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    // ----------------- ADD NEW RULE FUNCTIONS BELOW THIS LINE ----------------

    /* pattern validation */

    public function hasLowercase($message = null)
    {
        $this->setRule(__FUNCTION__, function ($field) {
            return preg_match('/[a-z]+/', $field) > 0;
        }, $message);

        return $this;
    }

    public function hasUppercase($message = null)
    {
        $this->setRule(__FUNCTION__, function ($field) {
            return preg_match('/[A-Z]+/', $field) > 0;
        }, $message);

        return $this;
    }

    public function hasNumber($message = null)
    {
        $this->setRule(__FUNCTION__, function ($field) {
            return preg_match('/[0-9]+/', $field) > 0;
        }, $message);

        return $this;
    }

    public function hasSymbol($message = null)
    {
        $this->setRule(__FUNCTION__, function ($field) {
            return preg_match('/[^a-zA-Z0-9_-]+/', $field) > 0;
        }, $message);

        return $this;
    }

    public function hasPattern($pattern, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($field, $pattern) {
            return preg_match($pattern, $field) > 0;
        }, $message, $pattern);

        return $this;
    }

    /* captcha validation */

    public function captcha($field, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $field) {
            $hash = $field . 'Hash';
            if (Validator::rpHash($_POST[$field]) == $_POST[$hash]) {
                return true;
            } else {
                return false;
            }
        }, $message, $field);

        return $this;
    }

    /* recaptcha validation */

    public function recaptcha($secret, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($response, $secret) {
            if (empty($response)) {
                return false;
            } else {
                $verify          = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response);
                $captcha_answer  = json_decode($verify);
                $captcha_success = false; // default
                if (isset($captcha_answer->success)) {
                    $captcha_success = $captcha_answer->success;
                }
                return $captcha_success;
            }
        }, $message, $secret);

        return $this;
    }

    public static function rpHash($value)
    {
        $hash = 5381;
        $value = strtoupper($value);
        if (self::is64bit() === true) {
            for ($i = 0; $i < strlen($value); $i++) {
                $hash = (self::leftShift32($hash, 5) + $hash) + ord(substr($value, $i));
            }
        } else {
            for ($i = 0; $i < strlen($value); $i++) {
                $hash = (($hash << 5) + $hash) + ord(substr($value, $i));
            }
        }

        return $hash;
    }

    protected static function is64bit()
    {
        $int = "9223372036854775807";
        $int = intval($int);
        if ($int == 9223372036854775807) {
            /* 64bit */

            return true;
        } elseif ($int == 2147483647) {
            /* 32bit */

            return false;
        } else {
            /* error */

            return "error";
        }
    }

    protected static function leftShift32($number, $steps)
    {
        // convert to binary (string)
        $binary = decbin($number);
        // left-pad with 0's if necessary
        $binary = str_pad($binary, 32, "0", STR_PAD_LEFT);
        // left shift manually
        $binary = $binary.str_repeat("0", $steps);
        // get the last 32 bits
        $binary = substr($binary, strlen($binary) - 32);
        // if it's a positive number return it
        // otherwise return the 2's complement
        return ($binary[0] == "0" ? bindec($binary) :
            -(pow(2, 31) - bindec(substr($binary, 1))));
    }

    /**
     * Field, if completed, has to be a valid email address.
     *
     * @param  string        $message
     * @return FormValidator
     */
    public function email($message = null)
    {
        $this->setRule(__FUNCTION__, function ($email) {
            if (strlen($email) == 0) {
                return true;
            }
            $isValid = true;
            $atIndex = strrpos($email, '@');
            if (is_bool($atIndex) && !$atIndex) {
                $isValid = false;
            } else {
                $domain = substr($email, $atIndex+1);
                $local = substr($email, 0, $atIndex);
                $localLen = strlen($local);
                $domainLen = strlen($domain);
                if ($localLen < 1 || $localLen > 64) {
                    $isValid = false;
                } elseif ($domainLen < 1 || $domainLen > 255) {
                    // domain part length exceeded
                    $isValid = false;
                } elseif ($local[0] == '.' || $local[$localLen-1] == '.') {
                    // local part starts or ends with '.'
                    $isValid = false;
                } elseif (preg_match('/\\.\\./', $local)) {
                    // local part has two consecutive dots
                    $isValid = false;
                } elseif (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
                    // character not valid in domain part
                    $isValid = false;
                } elseif (preg_match('/\\.\\./', $domain)) {
                    // domain part has two consecutive dots
                    $isValid = false;
                } elseif (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
                    // character not valid in local part unless
                    // local part is quoted
                    if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                        $isValid = false;
                    }
                }
                // check DNS
                if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
                    $isValid = false;
                }
            }

            return $isValid;
        }, $message);

        return $this;
    }

    /**
     * Field must be filled in.
     *
     * @param  string        $message
     * @return FormValidator
     */
    public function required($message = null)
    {
        $this->setRule(__FUNCTION__, function ($val) {
            if (is_scalar($val)) {
                $val = trim($val);
            }
            if ($val === 0 || $val === '0' || $val === false) {
                return true;
            }

            return !empty($val);
        }, $message);

        return $this;
    }

    /**
     * Field must contain a valid float value.
     *
     * @param  string        $message
     * @return FormValidator
     */
    public function float($message = null)
    {
        $this->setRule(__FUNCTION__, function ($val) {
            if (strlen($val) == 0) {
                return true;
            }
            return !(filter_var($val, FILTER_VALIDATE_FLOAT) === false);
        }, $message);

        return $this;
    }

    /**
     * Field must contain a valid integer value.
     *
     * @param  string        $message
     * @return FormValidator
     */
    public function integer($message = null)
    {
        $this->setRule(__FUNCTION__, function ($val) {
            if (strlen($val) == 0) {
                return true;
            }
            return !(filter_var($val, FILTER_VALIDATE_INT) === false);
        }, $message);

        return $this;
    }

    /**
     * Every character in field, if completed, must be a digit.
     * This is just like integer(), except there is no upper limit.
     *
     * @param  string        $message
     * @return FormValidator
     */
    public function digits($message = null)
    {
        $this->setRule(__FUNCTION__, function ($val) {
            return (strlen($val) === 0 || ctype_digit((string) $val));
        }, $message);

        return $this;
    }

    /**
     * Field must be a number greater than [or equal to] X.
     *
     * @param  numeric       $limit
     * @param  bool          $include Whether to include limit value.
     * @param  string        $message
     * @return FormValidator
     */
    public function min($limit, $include = true, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {

            $val = (float) $val;
            $limit = (float) $args[0];
            $inc = (bool) $args[1];

            return ($val > $limit || ($inc === true && $val === $limit));
        }, $message, array($limit, $include));

        return $this;
    }

    /**
     * Field must be a number greater than [or equal to] X.
     *
     * @param  numeric       $limit
     * @param  bool          $include Whether to include limit value.
     * @param  string        $message
     * @return FormValidator
     */
    public function max($limit, $include = true, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            if (strlen($val) === 0) {
                return true;
            }

            $val = (float) $val;
            $limit = (float) $args[0];
            $inc = (bool) $args[1];

            return ($val < $limit || ($inc === true && $val === $limit));
        }, $message, array($limit, $include));

        return $this;
    }

    /**
     * Field must be a number between X and Y.
     *
     * @param  numeric       $min
     * @param  numeric       $max
     * @param  bool          $include Whether to include limit value.
     * @param  string        $message
     * @return FormValidator
     */
    public function between($min, $max, $include = true, $message = null)
    {
        if (empty($message)) {
            $message = $this->_getDefaultMessage(__FUNCTION__, array($min, $max, $include));
        }

        $this->min($min, $include, $message)->max($max, $include, $message);

        return $this;
    }

    /**
     * Field has to be greater than or equal to X characters long.
     *
     * @param  int           $len
     * @param  string        $message
     * @return FormValidator
     */
    public function minlength($len, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            return !(strlen(trim($val)) < $args[0]);
        }, $message, array($len));

        return $this;
    }

    /**
     * Field has to be less than or equal to X characters long.
     *
     * @param  int           $len
     * @param  string        $message
     * @return FormValidator
     */
    public function maxlength($len, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            return !(strlen(trim($val)) > $args[0]);
        }, $message, array($len));

        return $this;
    }

    /**
     * Field has to be between minlength and maxlength characters long.
     *
     * @param int $minlength
     * @param int $maxlength
     * @
     */
    public function betweenlength($minlength, $maxlength, $message = null)
    {
        $message = empty($message) ? self::getDefaultMessage(__FUNCTION__, array($minlength, $maxlength)) : null;

        $this->minlength($minlength, $message)->max($maxlength, $message);

        return $this;
    }

    /**
     * Field has to be X characters long.
     *
     * @param  int           $len
     * @param  string        $message
     * @return FormValidator
     */
    public function length($len, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            return (strlen(trim($val)) == $args[0]);
        }, $message, array($len));

        return $this;
    }

    /**
     * Field is the same as another one (password comparison etc).
     *
     * @param  string        $field
     * @param  string        $label
     * @param  string        $message
     * @return FormValidator
     */
    public function matches($field, $label, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            return ((string) $args[0] == (string) $val);
        }, $message, array($this->_getVal($field), $label));

        return $this;
    }

    /**
     * Field is different from another one.
     *
     * @param  string        $field
     * @param  string        $label
     * @param  string        $message
     * @return FormValidator
     */
    public function notmatches($field, $label, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            return ((string) $args[0] != (string) $val);
        }, $message, array($this->_getVal($field), $label));

        return $this;
    }

    /**
     * Field must start with a specific substring.
     *
     * @param  string        $sub
     * @param  string        $message
     * @return FormValidator
     */
    public function startsWith($sub, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            $sub = $args[0];

            return (substr($val, 0, strlen($sub)) === $sub);
        }, $message, array($sub));

        return $this;
    }

    /**
     * Field must NOT start with a specific substring.
     *
     * @param  string        $sub
     * @param  string        $message
     * @return FormValidator
     */
    public function notstartsWith($sub, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            $sub = $args[0];

            return (strlen($val) === 0 || substr($val, 0, strlen($sub)) !== $sub);
        }, $message, array($sub));

        return $this;
    }

    /**
     * Field must end with a specific substring.
     *
     * @param  string        $sub
     * @param  string        $message
     * @return FormValidator
     */
    public function endsWith($sub, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            $sub = $args[0];

            return (substr($val, -strlen($sub)) === $sub);
        }, $message, array($sub));

        return $this;
    }

    /**
     * Field must not end with a specific substring.
     *
     * @param  string        $sub
     * @param  string        $message
     * @return FormValidator
     */
    public function notendsWith($sub, $message = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {
            $sub = $args[0];

            return (strlen($val) === 0 || substr($val, -strlen($sub)) !== $sub);
        }, $message, array($sub));

        return $this;
    }

    /**
     * Field has to be valid IP address.
     *
     * @param  string        $message
     * @return FormValidator
     */
    public function ip($message = null)
    {
        $this->setRule(__FUNCTION__, function ($val) {
            return (strlen(trim($val)) === 0 || filter_var($val, FILTER_VALIDATE_IP) !== false);
        }, $message);

        return $this;
    }

    /**
     * Field has to be valid internet address.
     *
     * @param  string        $message
     * @return FormValidator
     */
    public function url($message = null)
    {
        $this->setRule(__FUNCTION__, function ($val) {
            return (strlen(trim($val)) === 0 || filter_var($val, FILTER_VALIDATE_URL) !== false);
        }, $message);

        return $this;
    }

    /**
     * Date format.
     *
     * @return string
     */
    protected function _getDefaultDateFormat()
    {
        return 'd/m/Y';
    }

    /**
     * Field has to be a valid date.
     *
     * @param  string        $message
     * @return FormValidator
     */
    public function date($message = null, $format = null, $separator = null)
    {
        $this->setRule(__FUNCTION__, function ($val, $args) {

            if (strlen(trim($val)) === 0) {
                return true;
            }

            try {
                $dt = new \DateTime($val, new \DateTimeZone("UTC"));

                return true;
            } catch (\Exception $e) {
                return false;
            }
        }, $message, array($format, $separator));

        return $this;
    }

    /**
     * Field has to be a date later than or equal to X.
     *
     * @param  string|int    $date    Limit date
     * @param  string        $format  Date format
     * @param  string        $message
     * @return FormValidator
     */
    public function minDate($date = 0, $format = null, $message = null)
    {
        if (empty($format)) {
            $format = $this->_getDefaultDateFormat();
        }
        if (is_numeric($date)) {
            $date = new \DateTime($date . ' days'); // Days difference from today
        } else {
            $fieldValue = $this->_getVal($date);
            $date = ($fieldValue == false) ? $date : $fieldValue;

            $date = \DateTime::createFromFormat($format, $date);
        }

        $this->setRule(__FUNCTION__, function ($val, $args) {
            $format = $args[1];
            $limitDate = $args[0];

            return ($limitDate > \DateTime::createFromFormat($format, $val)) ? false : true;
        }, $message, array($date, $format));

        return $this;
    }

    /**
     * Field has to be a date later than or equal to X.
     *
     * @param  string|integer $date    Limit date.
     * @param  string         $format  Date format.
     * @param  string         $message
     * @return FormValidator
     */
    public function maxDate($date = 0, $format = null, $message = null)
    {
        if (empty($format)) {
            $format = $this->_getDefaultDateFormat();
        }
        if (is_numeric($date)) {
            $date = new \DateTime($date . ' days'); // Days difference from today
        } else {
            $fieldValue = $this->_getVal($date);
            $date = ($fieldValue == false) ? $date : $fieldValue;

            $date = \DateTime::createFromFormat($format, $date);
        }

        $this->setRule(__FUNCTION__, function ($val, $args) {
            $format = $args[1];
            $limitDate = $args[0];

            return !($limitDate < \DateTime::createFromFormat($format, $val));
        }, $message, array($date, $format));

        return $this;
    }

    /**
     * Field has to be a valid credit card number format.
     *
     * @see https://github.com/funkatron/inspekt/blob/master/Inspekt.php
     * @param  string        $message
     * @return FormValidator
     */
    public function ccnum($message = null)
    {
        $this->setRule(__FUNCTION__, function ($value) {
            $value = str_replace(' ', '', $value);
            $length = strlen($value);

            if ($length == 0) {
                return true;
            }

            if ($length < 13 || $length > 19) {
                return false;
            }

            $sum = 0;
            $weight = 2;

            for ($i = $length - 2; $i >= 0; $i--) {
                $digit = $weight * $value[$i];
                $sum += floor($digit / 10) + $digit % 10;
                $weight = $weight % 2 + 1;
            }

            $mod = (10 - $sum % 10) % 10;

            return ($mod == $value[$length - 1]);
        }, $message);

        return $this;
    }

    /**
     * Field has to be one of the allowed ones.
     *
     * @param  string|array  $allowed Allowed values.
     * @param  string        $message
     * @return FormValidator
     */
    public function oneOf($allowed, $message = null)
    {
        if (is_string($allowed)) {
            $allowed = explode(',', $allowed);
        }

        $this->setRule(__FUNCTION__, function ($val, $args) {
            return in_array($val, $args[0]);
        }, $message, array($allowed));

        return $this;
    }

    // --------------- END [ADD NEW RULE FUNCTIONS ABOVE THIS LINE] ------------

    /**
     * callback
     * @param  string        $name
     * @param  mixed         $function
     * @param  string        $message
     * @param  mixed         $params
     * @return FormValidator
     */
    public function callback($callback, $message = '', $params = array())
    {
        if (is_callable($callback)) {
            // If an array is callable, it is a method
            if (is_array($callback)) {
                $func = new \ReflectionMethod($callback[0], $callback[1]);
            } else {
                $func = new \ReflectionFunction($callback);
            }

            if (!empty($func)) {
                // needs a unique name to avoild collisions in the rules array
                $name = 'callback_' . sha1(uniqid());
                $this->setRule($name, function ($value) use ($func, $params, $callback) {
                    // Creates merged arguments array with validation target as first argument
                    $args = array_merge(array($value), (is_array($params) ? $params : array($params)));
                    if (is_array($callback)) {
                        // If callback is a method, the object must be the first argument
                        return $func->invokeArgs($callback[0], $args);
                    } else {
                        return $func->invokeArgs($args);
                    }
                }, $message, $params);
            }
        } else {
            throw new \Exception(sprintf('%s is not callable.', $function));
        }

        return $this;
    }

    // ------------------ PRE VALIDATION FILTERING -------------------
    /**
     * add a filter callback for the data
     *
     * @param  mixed         $callback
     * @return FormValidator
     */
    public function filter($callback)
    {
        if (is_callable($callback)) {
            $this->filters[] = $callback;
        }

        return $this;
    }

    /**
     * applies filters based on a data key
     *
     * @access protected
     * @param  string $key
     * @return void
     */
    protected function _applyFilters($key)
    {
        $this->_applyFilter($this->data[$key]);
    }

    /**
     * recursively apply filters to a value
     *
     * @access protected
     * @param  mixed $val reference
     * @return void
     */
    protected function _applyFilter(&$val)
    {
        if (is_array($val)) {
            foreach ($val as $key => &$item) {
                $this->_applyFilter($item);
            }
        } else {
            foreach ($this->filters as $filter) {
                $val = $filter($val);
            }
        }
    }

    /**
     * validate
     * @param  string $key
     * @param  string $label
     * @return bool
     */
    public function validate($key, $recursive = false, $label = '')
    {
        // set up field name for error message
        // $this->fields[$key] = (empty($label)) ? 'Field with the name of "' . $key . '"' : $label;
        if (!empty($label)) {
            $this->fields[$key] = $label;
        } else {
            if (!empty($_POST[$key])) {
                $this->fields[$key] = htmlspecialchars($_POST[$key]);
            } else {
                if ($this->language == 'en') {
                    $this->fields[$key] = 'This field ';
                } elseif ($this->language == 'fr') {
                    $this->fields[$key] = 'Ce champ ';
                } elseif ($this->language == 'de') {
                    $this->fields[$key] = 'Dieses Feld ';
                } elseif ($this->language == 'es') {
                    $this->fields[$key] = 'Este campo ';
                }
            }
        }

        // apply filters to the data
        $this->_applyFilters($key);

        $val = $this->_getVal($key);

        // validate the piece of data
        $this->_validate($key, $val, $recursive);

        // reset rules
        $this->rules = array();
        $this->filters = array();

        return $val;
    }

    /**
     * recursively validates a value
     *
     * @access protected
     * @param  string $key
     * @param  mixed  $val
     * @return bool
     */
    protected function _validate($key, $val, $recursive = false)
    {
        if ($recursive && is_array($val)) {
            // run validations on each element of the array
            foreach ($val as $index => $item) {
                if (!$this->_validate($key, $item, $recursive)) {
                    // halt validation for this value.
                    return false;
                }
            }

            return true;
        } else {
            foreach ($this->rules as $rule => $is_true) {
                if ($is_true) {
                    $function = $this->functions[$rule];
                    $args = $this->arguments[$rule]; // Arguments of rule

                    $valid = (empty($args)) ? $function($val) : $function($val, $args);
                    if ($valid === false) {
                        $this->registerError($rule, $key);

                        $this->rules = array();  // reset rules
                        $this->filters = array();

                        return false;
                    }
                }
            }

            $this->validData[$key] = $val;

            return true;
        }
    }

    /**
     * Whether errors have been found.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return (count($this->errors) > 0);
    }

    /**
     * Get specific error.
     *
     * @param  string $field
     * @return string
     */
    public function getError($field)
    {
        return $this->errors[$field];
    }

    /**
     * Get all errors.
     *
     * @return array
     */
    public function getAllErrors($keys = true)
    {
        return ($keys == true) ? $this->errors : array_values($this->errors);
    }

    public function getValidData()
    {
        return $this->validData;
    }

    /**
     * _getVal with added support for retrieving values from numeric and
     * associative multi-dimensional arrays. When doing so, use DOT notation
     * to indicate a break in keys, i.e.:
     *
     * key = "one.two.three"
     *
     * would search the array:
     *
     * array('one' => array(
     *      'two' => array(
     *          'three' => 'RETURN THIS'
     *      )
     * );
     *
     * @param  string $key
     * @return mixed
     */
    protected function _getVal($key)
    {
        // handle multi-dimensional arrays
        if (strpos($key, '.') !== false) {
            $arrData = null;
            $keys = explode('.', $key);
            $keyLen = count($keys);
            for ($i = 0; $i < $keyLen; ++$i) {
                if (trim($keys[$i]) == '') {
                    return false;
                } else {
                    if (is_null($arrData)) {
                        if (!isset($this->data[$keys[$i]])) {
                            return false;
                        }
                        $arrData = $this->data[$keys[$i]];
                    } else {
                        if (!isset($arrData[$keys[$i]])) {
                            return false;
                        }
                        $arrData = $arrData[$keys[$i]];
                    }
                }
            }

            return $arrData;
        } else {
            return (isset($this->data[$key])) ? $this->data[$key] : false;
        }
    }

    /**
     * Register error.
     *
     * @param string $rule
     * @param string $key
     * @param string $message
     */
    protected function registerError($rule, $key, $message = null)
    {
        $rules_with_field_name_display = array(
            'min',
            'max',
            'between',
            'minlength',
            'maxlength',
            'length',
            'matches',
            'notmatches',
            'startsWith',
            'notstartsWith',
            'endsWith',
            'notendsWith',
            'oneof'
        );
        if (empty($message)) {
            $message = $this->messages[$rule];
        }
        if (in_array($rule, $rules_with_field_name_display)) {
            $this->errors[$key] = sprintf($message, $key);
        } else {
            $this->errors[$key] = sprintf($message, $this->fields[$key]);
        }
    }

    /**
     * Set rule.
     *
     * @param string  $rule
     * @param closure $function
     * @param string  $message
     * @param array   $args
     */
    public function setRule($rule, $function, $message = '', $args = array())
    {
        if (!array_key_exists($rule, $this->rules)) {
            $this->rules[$rule] = true;
            if (!array_key_exists($rule, $this->functions)) {
                if (!is_callable($function)) {
                    die('Invalid function for rule: ' . $rule);
                }
                $this->functions[$rule] = $function;
            }
            $this->arguments[$rule] = $args; // Specific arguments for rule

            $this->messages[$rule] = (empty($message)) ? $this->_getDefaultMessage($rule, $args) : $message;
        }
    }

    /**
     * Get default error message.
     *
     * @param  string $key
     * @param  array  $args
     * @return string
     */
    protected function _getDefaultMessage($rule, $args = null)
    {
        if ($this->language == 'en') {
            switch ($rule) {
                case 'hasLowercase':
                    $message = '%s must contain at least one lowercase letter.';
                    break;

                case 'hasUppercase':
                    $message = '%s must contain at least one uppercase letter.';
                    break;

                case 'hasNumber':
                    $message = '%s must contain at least one number.';
                    break;

                case 'hasSymbol':
                    $message = '%s must contain at least one symbol.';
                    break;

                case 'hasPattern':
                    $message = 'invalid pattern.';
                    break;

                case 'captcha':
                    $message = 'invalid captcha.';
                    break;

                case 'email':
                    $message = '%s is an invalid email address.';
                    break;

                case 'ip':
                    $message = '%s is an invalid IP address.';
                    break;

                case 'url':
                    $message = '%s is an invalid url.';
                    break;

                case 'required':
                    $message = '%s is required.';
                    break;

                case 'float':
                    $message = '%s must consist of numbers only.';
                    break;

                case 'integer':
                    $message = '%s must consist of integer value.';
                    break;

                case 'digits':
                    $message = '%s must consist only of digits.';
                    break;

                case 'min':
                    $message = '%s must be greater than ';
                    if ($args[1] == true) {
                        $message .= 'or equal to ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'max':
                    $message = '%s must be less than ';
                    if ($args[1] == true) {
                        $message .= 'or equal to ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'between':
                    $message = '%s must be between ' . $args[0] . ' and ' . $args[1] . '.';
                    if ($args[2] == false) {
                        $message .= '(Without limits)';
                    }
                    break;

                case 'minlength':
                    $message = '%s must be at least ' . $args[0] . ' characters or longer.';
                    break;

                case 'maxlength':
                    $message = '%s must be no longer than ' . $args[0] . ' characters.';
                    break;

                case 'length':
                    $message = '%s must be exactly ' . $args[0] . ' characters in length.';
                    break;

                case 'matches':
                    $message = '%s must match ' . $args[1] . '.';
                    break;

                case 'notmatches':
                    $message = '%s must not match ' . $args[1] . '.';
                    break;

                case 'startsWith':
                    $message = '%s must start with "' . $args[0] . '".';
                    break;

                case 'notstartsWith':
                    $message = '%s must not start with "' . $args[0] . '".';
                    break;

                case 'endsWith':
                    $message = '%s must end with "' . $args[0] . '".';
                    break;

                case 'notendsWith':
                    $message = '%s must not end with "' . $args[0] . '".';
                    break;

                case 'date':
                    $message = '%s is not valid date.';
                    break;

                case 'mindate':
                    $message = '%s must be later than ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'maxdate':
                    $message = '%s must be before ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'oneof':
                    $message = '%s must be one of ' . implode(', ', $args[0]) . '.';
                    break;

                case 'ccnum':
                    $message = '%s must be a valid credit card number.';
                    break;

                default:
                    $message = '%s has an error.';
                    break;
            }
        } elseif ($this->language == 'de') {
            switch ($rule) {
                case 'hasLowercase':
                    $message = '%s muss einen Kleinbuchstaben enthalten.';
                    break;

                case 'hasUppercase':
                    $message = '%s muss einen Grossbuchstaben enthalten.';
                    break;

                case 'hasNumber':
                    $message = '%s muss eine Zahl enthalten.';
                    break;

                case 'hasSymbol':
                    $message = '%s muss ein Sonderzeichen enthalten.';
                    break;

                case 'hasPattern':
                    $message = 'Ungültiges Muster.';
                    break;

                case 'captcha':
                    $message = 'Ungültiges captcha.';
                    break;

                case 'email':
                    $message = '%s ist keine E-MAil Adresse.';
                    break;

                case 'ip':
                    $message = '%s is keine IP Adresse.';
                    break;

                case 'url':
                    $message = '%s ist keine URL.';
                    break;

                case 'required':
                    $message = '%s ist ein Pflichtfeld.';
                    break;

                case 'float':
                    $message = '%s muss eine Zahl sein.';
                    break;

                case 'integer':
                    $message = '%s muss eine Ganzzahl sein.';
                    break;

                case 'digits':
                    $message = '%s darf nur aus Zahlen bestehen.';
                    break;

                case 'min':
                    $message = '%s muss größer sein als ';
                    if ($args[1] == true) {
                        $message .= 'oder gleich zu ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'max':
                    $message = '%s muss kleiner sein als ';
                    if ($args[1] == true) {
                        $message .= 'oder gleich zu ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'between':
                    $message = '%s muss zwischen ' . $args[0] . ' und ' . $args[1] . '.';
                    if ($args[2] == false) {
                        $message .= '(Ohne Grenzen)';
                    }
                    break;

                case 'minlength':
                    $message = '%s muss mindestens ' . $args[0] . ' Zeichen enthalten oder mehr.';
                    break;

                case 'maxlength':
                    $message = '%s derf nicht mehr als ' . $args[0] . ' Zeichen enthalten.';
                    break;

                case 'length':
                    $message = '%s muss genau ' . $args[0] . ' Zeichen enthalten.';
                    break;

                case 'matches':
                    $message = '%s muss ' . $args[1] . ' gleichen.';
                    break;

                case 'notmatches':
                    $message = '%s darf nicht ' . $args[1] . ' enthalten.';
                    break;

                case 'startsWith':
                    $message = '%s muss mit "' . $args[0] . ' " anfangen.';
                    break;

                case 'notstartsWith':
                    $message = '%s darf nicht mit "' . $args[0] . '" anfangen.';
                    break;

                case 'endsWith':
                    $message = '%s muss auf "' . $args[0] . '" enden.';
                    break;

                case 'notendsWith':
                    $message = '%s darf nicht auf "' . $args[0] . '" enden.';
                    break;

                case 'date':
                    $message = '%s is kein Datum.';
                    break;

                case 'mindate':
                    $message = '%s muss später sein als ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'maxdate':
                    $message = '%s muss vor ' . $args[0]->format($args[1]) . ' sein.';
                    break;

                case 'oneof':
                    $message = '%s muss aus folgender Liste sein :' . implode(', ', $args[0]) . '.';
                    break;

                case 'ccnum':
                    $message = '%s muss eine korrekte Kreditkartennummer sein.';
                    break;

                default:
                    $message = '%s enthält einen Fehler.';
                    break;
            }
        } elseif ($this->language == 'es') {
            switch ($rule) {
                case 'hasLowercase':
                    $message = '%s debe contener mínimo una letra minúscula.';
                    break;

                case 'hasUppercase':
                    $message = '%s debe contener mínimo una letra mayúscula.';
                    break;

                case 'hasNumber':
                    $message = '%s debe contener mínimo un dígito.';
                    break;

                case 'hasSymbol':
                    $message = '%s debe contener mínimo un caracter símbolo.';
                    break;

                case 'hasPattern':
                    $message = 'patrón no válido.';
                    break;

                case 'captcha':
                    $message = 'captcha no válida.';
                    break;

                case 'email':
                    $message = '%s no es una dirección de email válida.';
                    break;

                case 'ip':
                    $message = '%s no es una dirección IP válida.';
                    break;

                case 'url':
                    $message = '%s  no es una url válida.';
                    break;

                case 'required':
                    $message = '%s es obligatorio.';
                    break;

                case 'float':
                    $message = '%s debe ser un número decimal.';
                    break;

                case 'integer':
                    $message = '%s debe ser un número entero.';
                    break;

                case 'digits':
                    $message = '%s debe contener sólo dígitos.';
                    break;

                case 'min':
                    $message = '%s debe ser mayor que ';
                    if ($args[1] == true) {
                        $message .= 'o igual a ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'max':
                    $message = '%s debe ser menor que ';
                    if ($args[1] == true) {
                        $message .= 'o igual a ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'between':
                    $message = '%s debe estar entre ' . $args[0] . ' y ' . $args[1] . '.';
                    if ($args[2] == false) {
                        $message .= '(Sin límites)';
                    }
                    break;

                case 'minlength':
                    $message = '%s debe ser mínimo de ' . $args[0] . ' caracteres o más.';
                    break;

                case 'maxlength':
                    $message = '%s debe ser máximo de ' . $args[0] . ' caracteres.';
                    break;

                case 'length':
                    $message = '%s debe ser exactamante de ' . $args[0] . ' caracteres.';
                    break;

                case 'matches':
                    $message = '%s debe coincidir con ' . $args[1] . '.';
                    break;

                case 'notmatches':
                    $message = '%s no puede coincidir con ' . $args[1] . '.';
                    break;

                case 'startsWith':
                    $message = '%s debe comenzar con "' . $args[0] . '".';
                    break;

                case 'notstartsWith':
                    $message = '%s no puede comenzar con "' . $args[0] . '".';
                    break;

                case 'endsWith':
                    $message = '%s debe terminar con "' . $args[0] . '".';
                    break;

                case 'notendsWith':
                    $message = '%s no puede terminar con "' . $args[0] . '".';
                    break;

                case 'date':
                    $message = '%s no es una fecha válida.';
                    break;

                case 'mindate':
                    $message = '%s debe ser después de ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'maxdate':
                    $message = '%s debe ser antes de ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'oneof':
                    $message = '%s debe ser uno de ' . implode(', ', $args[0]) . '.';
                    break;

                case 'ccnum':
                    $message = '%s debe ser un número de tarjeta de crédito válido.';
                    break;

                default:
                    $message = '%s tiene un error.';
                    break;
            }
        } elseif ($this->language == 'fr') {
            switch ($rule) {
                case 'hasLowercase':
                    $message = '%s doit contenir au moins une lettre minuscule.';
                    break;

                case 'hasUppercase':
                    $message = '%s doit contenir au moins une lettre majuscule.';
                    break;

                case 'hasNumber':
                    $message = '%s doit contenir au moins un chiffre.';
                    break;

                case 'hasSymbol':
                    $message = '%s doit contenir au moins un symbole.';
                    break;

                case 'hasPattern':
                    $message = 'motif invalide.';
                    break;

                case 'captcha':
                    $message = 'captcha invalide.';
                    break;

                case 'email':
                    $message = '%s n\'est pas un email valide.';
                    break;

                case 'ip':
                    $message = '%s n\'est pas une IP valide.';
                    break;

                case 'url':
                    $message = '%s n\'est pas une url valide.';
                    break;

                case 'required':
                    $message = '%s est obligatoire.';
                    break;

                case 'float':
                    $message = '%s n\'est pas un nombre décimal.';
                    break;

                case 'integer':
                    $message = '%s n\'est pas un nombre entier.';
                    break;

                case 'digits':
                    $message = '%s n\'est pas un nombre entier positif.';
                    break;

                case 'min':
                    $message = '%s doit être supérieur ';
                    if ($args[1] == true) {
                        $message .= 'ou égal ';
                    }
                    $message .= 'à ' . $args[0] . '.';
                    break;

                case 'max':
                    $message = '%s doit être inférieur ';
                    if ($args[1] == true) {
                        $message .= 'ou égal ';
                    }
                    $message .= 'à ' . $args[0] . '.';
                    break;

                case 'between':
                    $message = '%s doit être compris entre ' . $args[0] . ' et ' . $args[1] . '.';
                    if ($args[2] == false) {
                        $message .= '(sans limite)';
                    }
                    break;

                case 'minlength':
                    $message = '%s doit contenir au minimum ' . $args[0] . ' caractères.';
                    break;

                case 'maxlength':
                    $message = '%s doit contenir au maximum ' . $args[0] . ' caractères.';
                    break;

                case 'length':
                    $message = '%s doit contenir exactement ' . $args[0] . ' caractères.';
                    break;

                case 'matches':
                    $message = '%s doit être identique à ' . $args[1] . '.';
                    break;

                case 'notmatches':
                    $message = '%s ne doit pas être identique à ' . $args[1] . '.';
                    break;

                case 'startsWith':
                    $message = '%s doit commencer par "' . $args[0] . '".';
                    break;

                case 'notstartsWith':
                    $message = '%s ne doit pas commencer par "' . $args[0] . '".';
                    break;

                case 'endsWith':
                    $message = '%s doit finir par "' . $args[0] . '".';
                    break;

                case 'notendsWith':
                    $message = '%s ne doit pas finir par "' . $args[0] . '".';
                    break;

                case 'date':
                    $message = '%s n\'est pas une date valide.';
                    break;

                case 'mindate':
                    $message = '%s doit être après ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'maxdate':
                    $message = '%s doit être avant ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'oneof':
                    $message = '%s doit être une des valeurs suivantes : ' . implode(', ', $args[0]) . '.';
                    break;

                case 'ccnum':
                    $message = '%s n\'est pas un numéro de carte valide.';
                    break;

                default:
                    $message = '%s contient une erreur.';
                    break;
            }
        } elseif ($this->language == 'it') {
            switch ($rule) {
                case 'hasLowercase':
                    $message = '%s deve contenere almeno una lettera minuscola.';
                    break;

                case 'hasUppercase':
                    $message = '%s deve contenere almeno una lettera maiuscola.';
                    break;

                case 'hasNumber':
                    $message = '%s deve contenere almeno una cifra.';
                    break;

                case 'hasSymbol':
                    $message = '%s deve contenere almeno un simbolo.';
                    break;

                case 'hasPattern':
                    $message = 'pattern non valido.';
                    break;

                case 'captcha':
                    $message = 'captcha non valido.';
                    break;

                case 'email':
                    $message = '%s non è un\'email valida.';
                    break;

                case 'ip':
                    $message = '%s non è un indirizzo IP valido.';
                    break;

                case 'url':
                    $message = '%s non è un\'URL valida.';
                    break;

                case 'required':
                    $message = '%s è obbligatorio.';
                    break;

                case 'float':
                    $message = '%s non è un numero decimale.';
                    break;

                case 'integer':
                    $message = '%s non è un numero intero.';
                    break;

                case 'digits':
                    $message = '%s non è un numero intero positivo.';
                    break;

                case 'min':
                    $message = '%s deve essere superiore ';
                    if ($args[1] == true) {
                        $message .= 'o uguale ';
                    }
                    $message .= 'a ' . $args[0] . '.';
                    break;

                case 'max':
                    $message = '%s deve essere inferiore ';
                    if ($args[1] == true) {
                        $message .= 'o uguale ';
                    }
                    $message .= 'a ' . $args[0] . '.';
                    break;

                case 'between':
                    $message = '%s deve essere compreso tra ' . $args[0] . ' e ' . $args[1] . '.';
                    if ($args[2] == false) {
                        $message .= '(Illimitato)';
                    }
                    break;

                case 'minlength':
                    $message = '%s deve contenere come minimo ' . $args[0] . ' caratteri.';
                    break;

                case 'maxlength':
                    $message = '%s deve contenere al massimo ' . $args[0] . ' caratteri.';
                    break;

                case 'length':
                    $message = '%s deve contenere esattamente ' . $args[0] . ' caratteri.';
                    break;

                case 'matches':
                    $message = '%s deve essere identico a ' . $args[1] . '.';
                    break;

                case 'notmatches':
                    $message = '%s non deve essere identico a ' . $args[1] . '.';
                    break;

                case 'startsWith':
                    $message = '%s deve iniziare per "' . $args[0] . '".';
                    break;

                case 'notstartsWith':
                    $message = '%s non deve iniziare per "' . $args[0] . '".';
                    break;

                case 'endsWith':
                    $message = '%s deve finire per "' . $args[0] . '".';
                    break;

                case 'notendsWith':
                    $message = '%s non deve finire per "' . $args[0] . '".';
                    break;

                case 'date':
                    $message = '%s non è una data valida.';
                    break;

                case 'mindate':
                    $message = '%s deve essere successiva a ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'maxdate':
                    $message = '%s deve essere precedente a ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'oneof':
                    $message = '%s deve essere uno dei seguenti valori : ' . implode(', ', $args[0]) . '.';
                    break;

                case 'ccnum':
                    $message = '%s non è un numero di carta valido.';
                    break;

                default:
                    $message = '%s contiene un errore.';
                    break;
            }
        } elseif ($this->language == 'pt_br') {
            switch ($rule) {
                case 'hasLowercase':
                    $message = '%s deve conter pelo menos uma letra minúscula';
                    break;

                case 'hasUppercase':
                    $message = '%s deve conter pelo menos uma letra maiúscula';
                    break;

                case 'hasNumber':
                    $message = '%s deve conter pelo menos um número';
                    break;

                case 'hasSymbol':
                    $message = '%s deve conter pelo menos um símbolo';
                    break;

                case 'hasPattern':
                    $message = 'padrão inválido';
                    break;

                case 'captcha':
                    $message = 'código inválido';
                    break;

                case 'email':
                    $message = '%s é um endereço de email inválido';
                    break;

                case 'ip':
                    $message = '%s é um endereço IP inválido';
                    break;

                case 'url':
                    $message = '%s é uma URL inválida';
                    break;

                case 'required':
                    $message = '%s é obrigatório';
                    break;

                case 'float':
                    $message = '%s deve conter apenas números';
                    break;

                case 'integer':
                    $message = '%s deve conter um valor inteiro';
                    break;

                case 'digits':
                    $message = '%s deve conter apenas dígitos';
                    break;

                case 'min':
                    $message = '%s deve ser maior que ';
                    if ($args[1] == true) {
                        $message .= 'ou igual a ';
                    }
                    $message .= $args[0] . '';
                    break;

                case 'max':
                    $message = '%s deve ser menor que ';
                    if ($args[1] == true) {
                        $message .= 'ou igual a ';
                    }
                    $message .= $args[0] . '';
                    break;

                case 'between':
                    $message = '%s deve estar entre ' . $args[0] . ' e ' . $args[1] . '';
                    if ($args[2] == false) {
                        $message .= '(Sem limites)';
                    }
                    break;

                case 'minlength':
                    $message = '%s deve ter pelo menos ' . $args[0] . ' caracteres ou mais';
                    break;

                case 'maxlength':
                    $message = '%s não deve ter mais do que ' . $args[0] . ' caracteres';
                    break;

                case 'length':
                    $message = '%s deve ter exatamente ' . $args[0] . ' caracteres';
                    break;

                case 'matches':
                    $message = '%s deve combinar com ' . $args[1] . '';
                    break;

                case 'notmatches':
                    $message = '%s não deve combinar com ' . $args[1] . '';
                    break;

                case 'startsWith':
                    $message = '%s deve começar com "' . $args[0] . '"';
                    break;

                case 'notstartsWith':
                    $message = '%s não deve começar com "' . $args[0] . '"';
                    break;

                case 'endsWith':
                    $message = '%s deve terminar com "' . $args[0] . '"';
                    break;

                case 'notendsWith':
                    $message = '%s não deve terminar com "' . $args[0] . '"';
                    break;

                case 'date':
                    $message = '%s não é uma data válida';
                    break;

                case 'mindate':
                    $message = '%s deve ser depois de ' . $args[0]->format($args[1]) . '';
                    break;

                case 'maxdate':
                    $message = '%s deve ser antes de ' . $args[0]->format($args[1]) . '';
                    break;

                case 'oneof':
                    $message = '%s deve ser um dos ' . implode(', ', $args[0]) . '';
                    break;

                case 'ccnum':
                    $message = '%s deve ser um número de cartão de crédito válido';
                    break;

                default:
                    $message = '%s contem um erro';
                    break;
            }
        } elseif ($this->language == 'ru') {
            switch ($rule) {
                case 'hasLowercase':
                    $message = '%s должно содержать хотя бы одну строчную букву.';
                    break;

                case 'hasUppercase':
                    $message = '%s должно содержать как минимум одну заглавную букву.';
                    break;

                case 'hasNumber':
                    $message = '%s должно содержать хотя бы одно число.';
                    break;

                case 'hasSymbol':
                    $message = '%s должно содержать хотя бы один символ.';
                    break;

                case 'hasPattern':
                    $message = 'неверный шаблон.';
                    break;

                case 'captcha':
                    $message = 'неверная капча.';
                    break;

                case 'email':
                    $message = '%s не электронная почта.';
                    break;

                case 'ip':
                    $message = '%s неверный IP-адрес.';
                    break;

                case 'url':
                    $message = '%s недопустимый URL';
                    break;

                case 'required':
                    $message = '%s обязательно.';
                    break;

                case 'float':
                    $message = '%s должно состоять только из чисел.';
                    break;

                case 'integer':
                    $message = '%s должно состоять из целого значения.';
                    break;

                case 'digits':
                    $message = '%s должно состоять только из цифр';
                    break;

                case 'min':
                    $message = '%s должно быть больше, чем ';
                    if ($args[1] == true) {
                        $message .= 'или равно ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'max':
                    $message = '%s должно быть меньше ';
                    if ($args[1] == true) {
                        $message .= 'или равно ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'between':
                    $message = '%s должно быть между ' . $args[0] . ' и ' . $args[1] . '.';
                    if ($args[2] == false) {
                        $message .= '(Без ограничений)';
                    }
                    break;

                case 'minlength':
                    $message = '%s должно быть не менее ' . $args[0] . ' символов или более.';
                    break;

                case 'maxlength':
                    $message = '%s должно быть не более ' . $args[0] . ' символов.';
                    break;

                case 'length':
                    $message = '%s должно быть равно ' . $args[0] . ' символов в длину.';
                    break;

                case 'matches':
                    $message = '%s должно соответствовать ' . $args[1] . '.';
                    break;

                case 'notmatches':
                    $message = '%s не должны совпадать ' . $args[1] . '.';
                    break;

                case 'startsWith':
                    $message = '%s должно начинаться с "' . $args[0] . '".';
                    break;

                case 'notstartsWith':
                    $message = '%s не следует начинать с "' . $args[0] . '".';
                    break;

                case 'endsWith':
                    $message = '%s должно заканчиваться "' . $args[0] . '".';
                    break;

                case 'notendsWith':
                    $message = '%s не должно заканчиваться "' . $args[0] . '".';
                    break;

                case 'date':
                    $message = '%s недействительная дата.';
                    break;

                case 'mindate':
                    $message = '%s должно быть позже, чем ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'maxdate':
                    $message = '%s должно быть до ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'oneof':
                    $message = '%s должно быть одним из ' . implode(', ', $args[0]) . '.';
                    break;

                case 'ccnum':
                    $message = '%s должно быть действительным номером кредитной карты.';
                    break;

                default:
                    $message = '%s имеет ошибку.';
                    break;
            }
        } elseif ($this->language == 'ua') {
            switch ($rule) {
                case 'hasLowercase':
                    $message = '%s повинно містити щонайменше одну малу літеру.';
                    break;

                case 'hasUppercase':
                    $message = '%s повинно містити як мінімум одну велику літеру.';
                    break;

                case 'hasNumber':
                    $message = '%s повинно містити хоча б одне число.';
                    break;

                case 'hasSymbol':
                    $message = '%s повинно містити хоча б один символ.';
                    break;

                case 'hasPattern':
                    $message = 'невірний шаблон.';
                    break;

                case 'captcha':
                    $message = 'невірна капча.';
                    break;

                case 'email':
                    $message = '%s невірна электронна пошта.';
                    break;

                case 'ip':
                    $message = '%s невірна IP-адреса.';
                    break;

                case 'url':
                    $message = '%s недопустимий URL';
                    break;

                case 'required':
                    $message = '%s обов\'язково.';
                    break;

                case 'float':
                    $message = '%s повинно складатися тільки з чисел.';
                    break;

                case 'integer':
                    $message = '%s повинно складатися з цілого значення.';
                    break;

                case 'digits':
                    $message = '%s повинно складатися тільки з цифр';
                    break;

                case 'min':
                    $message = '%s повинно бути більше, чим ';
                    if ($args[1] == true) {
                        $message .= 'чи рівне ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'max':
                    $message = '%s повинно бути меньше ';
                    if ($args[1] == true) {
                        $message .= 'чи рівне ';
                    }
                    $message .= $args[0] . '.';
                    break;

                case 'between':
                    $message = '%s повинно бути між ' . $args[0] . ' и ' . $args[1] . '.';
                    if ($args[2] == false) {
                        $message .= '(Без обмежень)';
                    }
                    break;

                case 'minlength':
                    $message = '%s повинно бути не меньше ' . $args[0] . ' символів чи більше.';
                    break;

                case 'maxlength':
                    $message = '%s повинно бути не більше ' . $args[0] . ' символів.';
                    break;

                case 'length':
                    $message = '%s повинно бути рівно ' . $args[0] . ' символів в довжину.';
                    break;

                case 'matches':
                    $message = '%s має відповідати ' . $args[1] . '.';
                    break;

                case 'notmatches':
                    $message = '%s не повинні збігатися ' . $args[1] . '.';
                    break;

                case 'startsWith':
                    $message = '%s має починатися з "' . $args[0] . '".';
                    break;

                case 'notstartsWith':
                    $message = '%s не слід починати з "' . $args[0] . '".';
                    break;

                case 'endsWith':
                    $message = '%s має закінчуватися "' . $args[0] . '".';
                    break;

                case 'notendsWith':
                    $message = '%s не має закінчуватися "' . $args[0] . '".';
                    break;

                case 'date':
                    $message = '%s недійсна дата.';
                    break;

                case 'mindate':
                    $message = '%s має бути пізніше, ніж ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'maxdate':
                    $message = '%s має бути до ' . $args[0]->format($args[1]) . '.';
                    break;

                case 'oneof':
                    $message = '%s має бути одним з ' . implode(', ', $args[0]) . '.';
                    break;

                case 'ccnum':
                    $message = '%s має бути дійсним номером кредитної картки.';
                    break;

                default:
                    $message = '%s має помилку.';
                    break;
            }
        }

        return $message;
    }
}
