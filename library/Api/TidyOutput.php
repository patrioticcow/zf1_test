<?php
class Api_TidyOutput extends Zend_Controller_Plugin_Abstract
{
	/**
     * @var tidy|null
     */
    protected $_tidy;

    /**
     * @var array
     */
    protected static $_tidyConfig = array('indent'            =>true,
                                          'indent-attributes' => true,
                                          'output-xhtml'      => true,
                                          'drop-proprietary-attributes' => true,
                                          'wrap'              => 120,
    );

    protected static $_diagnose = true;

    /**
     * @var string
     */
    protected static $_tidyEncoding = 'UTF8';

    /**
     * Switch diagnosing HTML mode
     */
    public static function setDiagnose($diagnose = true)
    {
        self::$_diagnose = (bool) $diagnose;
    }

    public static function setConfig(array $config)
    {
        self::$_tidyConfig = $config;
    }

    public static function setEncoding($encoding)
    {
        if (!is_string($encoding)) {
            throw new InvalidArgumentException('Encoding must be a string');
        }
        self::$_tidyEncoding = $encoding;
    }

    protected function getTidy($string = null)
    {
        if (null === $this->_tidy) {
            if (null === $string) {
                $this->_tidy = new tidy();
            } else {
                $this->_tidy = tidy_parse_string($string,
                                                 self::$_tidyConfig,
                                                 self::$_tidyEncoding);
            }
        }
        return $this->_tidy;
    }

    public function dispatchLoopShutdown()
    {
        $response = $this->getResponse();
        $tidy     = $this->getTidy($response->getBody());

        if ('development' === APPLICATION_ENV) {
            if (true === self::$_diagnose ) {
                $tidy->diagnose();
                $lines = array_reverse(explode("\n", $tidy->errorBuffer));
                array_shift($lines);
                foreach ($lines as $line) {
                    Zend_Registry::get('logger')->log($line, Zend_Log::INFO);
                }
            }
        }
        $tidy->cleanRepair();
        $response->setBody((string) $tidy);
    }
}