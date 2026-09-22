<?php

namespace Business\Utility;

use IteratorAggregate;
use ArrayIterator;
use Laminas\Http\PhpEnvironment\Response as HttpResponse;

class ApiResponse implements IteratorAggregate
{
    const CONTENT_TYPE = 'application/json';
    const SUCCESS = 'success';
    const ERROR = 'error';
    public $message;
    public $type;
    public $extra;

    public function __construct(string $message = '', string $type = self::SUCCESS, array $extra = [])
    {
        $this->message = $message;
        $this->type = $type;
        $this->extra = $extra;
    }

    public function __get($name)
    {
        return array_merge([
            'type' => $this->type,
            'message' => $this->message,
        ], $this->extra);
    }

    public function getIterator(): \Traversable
    {
        return new ArrayIterator(
            $this->__get(null)
        );
    }

    public function getStatusCode(): int
    {
        return $this->type === self::ERROR ? 400 : 200;
    }

    public function toHttpResponse(): HttpResponse
    {
        $statusCode = $this->getStatusCode();
        $response = new HttpResponse();
        $response->setStatusCode($statusCode); // Utilizamos la variable $statusCode
        $response->getHeaders()->addHeaderLine('Content-Type', self::CONTENT_TYPE);
        $response->setContent(json_encode($this->__get(null), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        return $response;
    }

    public static function download(string $filename, string $stream, string $contentType): HttpResponse
    {
        $response = new HttpResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', $contentType); // application/pdf
        $headers->addHeaderLine('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $headers->addHeaderLine('Content-Length', strlen($stream));
        $headers->addHeaderLine('Content-Transfer-Encoding', 'binary');
        $headers->addHeaderLine('Cache-Control', 'private, max-age=0, must-revalidate');
        $response->setContent($stream);

        return $response;
    }
}