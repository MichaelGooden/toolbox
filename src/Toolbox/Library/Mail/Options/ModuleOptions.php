<?php
namespace Toolbox\Library\Mail\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $charset;

    protected $encoding;

    protected $transport;

    /**
     * @param $charset
     * @return $this
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param mixed $encoding
     * @return $this
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    public function setTransport($transport)
    {
        $this->transport = $transport;
    }

    public function getTransport()
    {
        return $this->transport;
    }
}
