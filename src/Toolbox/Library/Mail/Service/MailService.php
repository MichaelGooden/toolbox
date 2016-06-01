<?php
namespace Toolbox\Library\Mail\Service;

use Toolbox\Library\Mail\Options\ModuleOptions;
use Zend\Mail\Message as MailMessage;

use Zend\Mail\Transport\TransportInterface;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

class MailService
{
    protected $mailTo;

    protected $mailFrom;

    protected $mailReplyTo;

    protected $mailSubject;

    protected $mailBodyHtml;

    protected $mailBodyText;

    protected $mailCharset;

    protected $mailEncoding;

    protected $mailTransport;

    protected $mailBcc;

    protected $mailCc;


    protected $renderer;

    protected $transport;

    public function __construct(
        PhpRenderer $phpRenderer,
        ModuleOptions $moduleOptions,
        TransportInterface $transport)
    {
        $this->renderer     = $phpRenderer;
        $this->transport    = $transport;
        $this->mailCharset  = $moduleOptions->getCharset();
        $this->mailEncoding = $moduleOptions->getEncoding();
    }

    protected function checkMailValidity()
    {
        if (is_null($this->mailTo)) {
            return false;
        }

        if (is_null($this->mailFrom)) {
            return false;
        }

        if (is_null($this->mailBodyText) && is_null($this->mailBodyHtml)) {
            return false;
        }

        if (is_null($this->mailSubject)) {
            return false;
        }

        return true;
    }

    public function sendMail()
    {

        if (false === $this->checkMailValidity()) {
            throw new \InvalidArgumentException('E-Mail can not be sent as the required fields where not filled in.');
        }

        $mimeBody = new MimeMessage();

        if ($this->mailBodyHtml instanceof ViewModel) {
            $htmlBodyPart           = new MimePart($this->createBodyFromViewModel($this->mailBodyHtml));
            $htmlBodyPart->charset  = $this->mailCharset;
            $htmlBodyPart->encoding = $this->mailEncoding;
            $htmlBodyPart->type     = 'text/html';

            $mimeBody->addPart($htmlBodyPart);
        }

        if ($this->mailBodyText instanceof ViewModel) {
            $textBodyPart           = new MimePart($this->createBodyFromViewModel($this->mailBodyText));
            $textBodyPart->charset  = $this->mailCharset;
            $textBodyPart->encoding = $this->mailEncoding;
            $textBodyPart->type     = 'text/plain';

            $mimeBody->addPart($textBodyPart);
        }

        $mailMessage = new MailMessage();
        $mailMessage->setBody($mimeBody);
        $mailMessage->setEncoding($this->mailEncoding);
        $mailMessage->setFrom($this->mailFrom);
        $mailMessage->setSender($this->mailFrom);
        $mailMessage->setTo($this->mailTo);

        if ($this->mailBcc != '') {
            $mailMessage->setBcc($this->mailBcc);
        }

        if ($this->mailCc != '')
        {
            $mailMessage->setCc($this->mailCc);
        }


        $mailMessage->setSubject($this->mailSubject);

        if (2 <= count($mimeBody->getParts())) {
            $mailMessage->getHeaders()->get('content-type')->setType('multipart/alternative');
        }

        try {
            $this->transport->send($mailMessage);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

    }

    /**
     * @param ViewModel $viewModel
     * @return string
     */
    public function createBodyFromViewModel(ViewModel $viewModel)
    {
        return $this->renderer->render($viewModel);
    }

    /**
     * @param mixed $mailBodyHtml
     * @return MailService
     */
    public function setMailBodyHtml($mailBodyHtml)
    {
        $this->mailBodyHtml = $mailBodyHtml;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailBodyHtml()
    {
        return $this->mailBodyHtml;
    }

    /**
     * @param mixed $mailBodyText
     * @return MailService
     */
    public function setMailBodyText($mailBodyText)
    {
        $this->mailBodyText = $mailBodyText;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailBodyText()
    {
        return $this->mailBodyText;
    }

    /**
     * @param mixed $mailCharset
     * @return MailService
     */
    public function setMailCharset($mailCharset)
    {
        $this->mailCharset = $mailCharset;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailCharset()
    {
        return $this->mailCharset;
    }

    /**
     * @param mixed $mailEncoding
     * @return MailService
     */
    public function setMailEncoding($mailEncoding)
    {
        $this->mailEncoding = $mailEncoding;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailEncoding()
    {
        return $this->mailEncoding;
    }

    /**
     * @param mixed $mailFrom
     * @return MailService
     */
    public function setMailFrom($mailFrom)
    {
        $this->mailFrom = $mailFrom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailFrom()
    {
        return $this->mailFrom;
    }

    /**
     * @param mixed $mailSubject
     * @return MailService
     */
    public function setMailSubject($mailSubject)
    {
        $this->mailSubject = $mailSubject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailSubject()
    {
        return $this->mailSubject;
    }

    /**
     * @param mixed $mailTo
     * @return MailService
     */
    public function setMailTo($mailTo)
    {
        $this->mailTo = $mailTo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailTo()
    {
        return $this->mailTo;
    }

    /**
     * @param mixed $mailReplyTo
     * @return MailService
     */
    public function setMailReplyTo($mailReplyTo)
    {
        $this->mailReplyTo = $mailReplyTo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailReplyTo()
    {
        return $this->mailReplyTo;
    }

    /**
     * @param $mailBcc
     * @return $this
     */
    public function setMailBcc($mailBcc)
    {
        $this->mailBcc = $mailBcc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailBcc()
    {
        return $this->mailBcc;
    }

    /**
     * @param $mailCc
     * @return $this
     */
    public function setMailCc($mailCc)
    {
        $this->mailCc = $mailCc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailCc()
    {
        return $this->mailCc;
    }


}
