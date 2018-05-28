<?php

namespace Emgag\VGWort;

use SoapFault;

/**
 * Service for using the VG Wort Message API
 */
class MessageService
{
    protected $messageService;

    /**
     * MessageService constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->messageService = new \Emgag\VGWort\v1_11\MessageService([
            "authentication"     => SOAP_AUTHENTICATION_BASIC,
            "login"              => $username,
            "password"           => $password,
            "connection_timeout" => 60
        ]);
    }

    /**
     * Builds a new message request and tries to send it.
     *
     * @param string $id
     * @param array  $authors
     * @param string $title
     * @param string $text
     * @param string $url
     * @return MessageResponse|null
     */
    public function newMessage($id, array $authors, $title, $text, $url)
    {
        if (empty($id) || count($authors) < 1 || empty($title) || empty($text) || empty($url)) {
            return null;
        }
        
        $messageRequest = new MessageRequest([
            "id"      => $id,
            "authors" => $authors,
            "title"   => $title,
            "text"    => $text,
            "url"     => $url
        ]);

        $messageResponse = new MessageResponse();

        try {
            $response = $this->messageService->newMessage($messageRequest->get());
            $messageResponse->success($response);
        } catch (SoapFault $exception) {
            $messageResponse->error($exception->detail);
        }

        return $messageResponse;
    }
}