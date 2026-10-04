<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * ------------------------------------------------------------------
 * Class Response
 * ------------------------------------------------------------------
 */

class Response
{
    /**
     * HTTP Status Code
     *
     * @var int
     */
    private $status_code = 200;

    /**
     * Response Headers
     *
     * @var array
     */
    private $headers = array();

    /**
     * Response Content
     *
     * @var mixed
     */
    private $content = NULL;

    /**
     * Cookies to set
     *
     * @var array
     */
    private $cookies = array();

    /**
     * Whether headers have been sent
     *
     * @var boolean
     */
    private $headers_sent = FALSE;

    /**
     * HTTP status code text map
     *
     * @var array
     */
    private static $status_texts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',

        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        422 => 'Unprocessable Entity',
        429 => 'Too Many Requests',

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
    );


    // ---------------------------------------------------------------
    // CONSTRUCTOR
    // ---------------------------------------------------------------

    /**
     * Class constructor
     *
     * @param mixed $content
     * @param int   $status_code
     */
    public function __construct($content = NULL, $status_code = 200)
    {
        $this->content     = $content;
        $this->status_code = $status_code;
    }


    // ---------------------------------------------------------------
    // STATUS CODE
    // ---------------------------------------------------------------

    /**
     * Set HTTP Status Code
     *
     * @param int $status_code
     * @return $this
     */
    public function set_status_code($status_code)
    {
        $this->status_code = (int) $status_code;

        return $this;
    }


    /**
     * Get current HTTP status code
     *
     * @return int
     */
    public function get_status_code()
    {
        return $this->status_code;
    }


    /**
     * Get status text
     *
     * @param int|null $code
     * @return string
     */
    public function get_status_text($code = NULL)
    {
        $code = $code ?: $this->status_code;

        return isset(self::$status_texts[$code])
            ? self::$status_texts[$code]
            : 'Unknown';
    }


    /**
     * Check if informational
     *
     * @return boolean
     */
    public function is_informational()
    {
        return $this->status_code >= 100 &&
               $this->status_code < 200;
    }


    /**
     * Check if successful
     *
     * @return boolean
     */
    public function is_successful()
    {
        return $this->status_code >= 200 &&
               $this->status_code < 300;
    }


    /**
     * Check if redirect
     *
     * @return boolean
     */
    public function is_redirect()
    {
        return $this->status_code >= 300 &&
               $this->status_code < 400;
    }


    /**
     * Check if client error
     *
     * @return boolean
     */
    public function is_client_error()
    {
        return $this->status_code >= 400 &&
               $this->status_code < 500;
    }


    /**
     * Check if server error
     *
     * @return boolean
     */
    public function is_server_error()
    {
        return $this->status_code >= 500 &&
               $this->status_code < 600;
    }


    /**
     * Check if error
     *
     * @return boolean
     */
    public function is_error()
    {
        return $this->status_code >= 400;
    }


    /**
     * Check if specific status
     *
     * @param int $code
     * @return boolean
     */
    public function is_status($code)
    {
        return $this->status_code === (int) $code;
    }


    // ---------------------------------------------------------------
    // HEADERS
    // ---------------------------------------------------------------

    /**
     * Add Response Header(s)
     *
     * @param string|array $name
     * @param string $value
     * @return $this
     */
    public function add_header($name, $value = '')
    {
        if (is_array($name))
        {
            foreach ($name as $key => $val)
            {
                $this->headers[$key] = $val;
            }
        }
        else
        {
            $this->headers[$name] = $value;
        }

        return $this;
    }


    /**
     * Remove response header
     *
     * @param string $name
     * @return $this
     */
    public function remove_header($name)
    {
        if (isset($this->headers[$name]))
        {
            unset($this->headers[$name]);
        }

        return $this;
    }


    /**
     * Check response header
     *
     * @param string $name
     * @return boolean
     */
    public function has_header($name)
    {
        return isset($this->headers[$name]);
    }


    /**
     * Get response header
     *
     * @param string $name
     * @return string|null
     */
    public function get_header($name)
    {
        return isset($this->headers[$name])
            ? $this->headers[$name]
            : NULL;
    }


    /**
     * Get all response headers
     *
     * @return array
     */
    public function get_headers()
    {
        return $this->headers;
    }


    /**
     * Set Content-Type
     *
     * @param string $mime
     * @param string $charset
     * @return $this
     */
    public function content_type($mime, $charset = 'utf-8')
    {
        $value = $charset
            ? $mime . '; charset=' . $charset
            : $mime;

        return $this->add_header(
            'Content-Type',
            $value
        );
    }


    /**
     * Set cache headers
     *
     * @param int $seconds
     * @param string $visibility
     * @return $this
     */
    public function cache(
        $seconds = 3600,
        $visibility = 'public'
    )
    {
        if ($seconds <= 0)
        {
            $this->add_header(
                'Cache-Control',
                'no-store, no-cache, must-revalidate'
            );

            $this->add_header(
                'Pragma',
                'no-cache'
            );

            $this->add_header(
                'Expires',
                '0'
            );
        }
        else
        {
            $this->add_header(
                'Cache-Control',
                $visibility . ', max-age=' . $seconds
            );

            $this->add_header(
                'Expires',
                gmdate(
                    'D, d M Y H:i:s',
                    time() + $seconds
                ) . ' GMT'
            );
        }

        return $this;
    }


    /**
     * Disable caching
     *
     * @return $this
     */
    public function no_cache()
    {
        return $this->cache(0);
    }


    /**
     * Security headers
     *
     * @param array $overrides
     * @return $this
     */
    public function with_security_headers(
        $overrides = array()
    )
    {
        $defaults = array(
            'X-Content-Type-Options' =>
                'nosniff',

            'X-Frame-Options' =>
                'SAMEORIGIN',

            'X-XSS-Protection' =>
                '1; mode=block',

            'Referrer-Policy' =>
                'strict-origin-when-cross-origin',

            'Permissions-Policy' =>
                'geolocation=(), microphone=()',
        );

        return $this->add_header(
            array_merge(
                $defaults,
                $overrides
            )
        );
    }


    // ---------------------------------------------------------------
    // CORS
    // ---------------------------------------------------------------

    /**
     * Add CORS headers
     *
     * @param string $origin
     * @param string $methods
     * @param string $headers
     * @param bool $credentials
     * @return $this
     */
    public function with_cors(
        $origin = '*',
        $methods = 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
        $headers = 'Content-Type, Authorization, Accept, X-Requested-With',
        $credentials = FALSE
    )
    {
        /*
         * Allow Origin
         */
        $this->add_header(
            'Access-Control-Allow-Origin',
            $origin
        );

        /*
         * Allow Methods
         */
        $this->add_header(
            'Access-Control-Allow-Methods',
            $methods
        );

        /*
         * Allow Headers
         */
        $this->add_header(
            'Access-Control-Allow-Headers',
            $headers
        );

        /*
         * Preflight cache
         */
        $this->add_header(
            'Access-Control-Max-Age',
            '86400'
        );

        /*
         * Credentials
         */
        if ($credentials)
        {
            $this->add_header(
                'Access-Control-Allow-Credentials',
                'true'
            );
        }

        return $this;
    }


    /**
     * Resolve which origin may be echoed back
     *
     * Reads allow_origin from app/config/api.php so this class and the Api
     * library can never disagree about what is allowed. Returns an empty
     * string when the caller's origin is not allowed, which makes the
     * browser block the response.
     *
     * @return string
     */
    private function resolve_cors_origin()
    {
        $origin = isset($_SERVER['HTTP_ORIGIN'])
            ? $_SERVER['HTTP_ORIGIN']
            : '';

        $allow = trim(
            (string) (function_exists('config_item')
                ? config_item('allow_origin')
                : '')
        );

        if ($allow === '' || $allow === '*')
        {
            /*
             * Echo the caller back rather than "*" so credentialed
             * requests are not rejected. Keep "*" when there is no
             * Origin at all, e.g. curl or a server side call.
             */
            return $origin !== '' ? $origin : '*';
        }

        $allowed = array_filter(
            array_map('trim', explode(',', $allow))
        );

        return in_array($origin, $allowed, TRUE)
            ? $origin
            : '';
    }


    /**
     * Automatically add CORS headers
     *
     * @return $this
     */
    public function enable_cors()
    {
        $allow_origin = $this->resolve_cors_origin();

        if ($allow_origin !== '')
        {
            $this->add_header(
                'Access-Control-Allow-Origin',
                $allow_origin
            );

            $this->add_header(
                'Vary',
                'Origin'
            );
        }

        $this->add_header(
            'Access-Control-Allow-Methods',
            'GET, POST, PUT, PATCH, DELETE, OPTIONS'
        );

        $this->add_header(
            'Access-Control-Allow-Headers',
            'Content-Type, Authorization, Accept, X-Requested-With'
        );

        $this->add_header(
            'Access-Control-Max-Age',
            '86400'
        );

        return $this;
    }


    // ---------------------------------------------------------------
    // CONTENT
    // ---------------------------------------------------------------

    /**
     * Set response content
     *
     * @param mixed $content
     * @return $this
     */
    public function set_content($content)
    {
        $this->content = $content;

        return $this;
    }


    /**
     * Get response content
     *
     * @return mixed
     */
    public function get_content()
    {
        return $this->content;
    }


    /**
     * Append content
     *
     * @param mixed $content
     * @return $this
     */
    public function append_content($content)
    {
        $this->content .= $content;

        return $this;
    }


    /**
     * Set HTML content
     *
     * @param mixed $content
     * @return $this
     */
    public function set_html_content($content)
    {
        $this->content_type('text/html');

        $this->set_content($content);

        return $this;
    }


    /**
     * Set JSON content
     *
     * @param mixed $data
     * @param int $options
     * @return $this
     */
    public function set_json_content(
        $data,
        $options = 0
    )
    {
        $this->content_type(
            'application/json'
        );

        $this->content = json_encode(
            $data,
            $options
        );

        return $this;
    }


    /**
     * Set plain text
     *
     * @param string $content
     * @return $this
     */
    public function set_text_content($content)
    {
        $this->content_type(
            'text/plain'
        );

        $this->set_content($content);

        return $this;
    }


    /**
     * Set XML content
     *
     * @param string $xml
     * @return $this
     */
    public function set_xml_content($xml)
    {
        $this->content_type(
            'application/xml'
        );

        $this->set_content($xml);

        return $this;
    }


    /**
     * Get content length
     *
     * @return int
     */
    public function get_content_length()
    {
        return strlen(
            (string) $this->content
        );
    }


    /**
     * Check empty response
     *
     * @return boolean
     */
    public function is_empty()
    {
        return $this->content === NULL ||
               $this->content === '';
    }


    // ---------------------------------------------------------------
    // SEND
    // ---------------------------------------------------------------

    /**
     * Send headers
     *
     * @return void
     */
    public function send_headers()
    {
        if ($this->headers_sent)
        {
            return;
        }

        if (!headers_sent())
        {
            /*
             * =====================================================
             * CORS
             * =====================================================
             */

            $allow_origin = $this->resolve_cors_origin();

            if ($allow_origin !== '')
            {
                header(
                    'Access-Control-Allow-Origin: ' . $allow_origin
                );

                header('Vary: Origin');
            }

            /*
             * CORS methods
             */
            header(
                'Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS'
            );

            /*
             * CORS request headers
             */
            header(
                'Access-Control-Allow-Headers: Content-Type, Authorization, Accept, X-Requested-With'
            );

            /*
             * Cache preflight
             */
            header(
                'Access-Control-Max-Age: 86400'
            );


            /*
             * =====================================================
             * HTTP STATUS
             * =====================================================
             */

            http_response_code(
                $this->status_code
            );


            /*
             * =====================================================
             * NORMAL RESPONSE HEADERS
             * =====================================================
             */

            foreach (
                $this->headers
                as $name => $value
            )
            {
                header(
                    "$name: $value"
                );
            }


            /*
             * =====================================================
             * COOKIES
             * =====================================================
             */

            $this->send_cookies();
        }

        $this->headers_sent = TRUE;
    }


    /**
     * Send cookies
     *
     * @return void
     */
    private function send_cookies()
    {
        foreach (
            $this->cookies
            as $cookie
        )
        {
            setcookie(
                $cookie['name'],
                $cookie['value'],
                array(
                    'expires' =>
                        $cookie['expiration'] > 0
                            ? time() + $cookie['expiration']
                            : 0,

                    'path' =>
                        $cookie['path'],

                    'domain' =>
                        $cookie['domain'],

                    'secure' =>
                        $cookie['secure'],

                    'httponly' =>
                        $cookie['httponly'],

                    'samesite' =>
                        $cookie['samesite'],
                )
            );
        }

        $this->cookies = array();
    }


    /**
     * Send response
     *
     * @return void
     */
    public function send()
    {
        $this->send_headers();

        if ($this->content !== NULL)
        {
            echo $this->content;
        }
    }


    /**
     * Send JSON
     *
     * @param mixed $data
     * @param int $status_code
     * @param int $options
     * @return void
     */
    public function send_json(
        $data,
        $status_code = 200,
        $options = 0
    )
    {
        $this->set_status_code(
            $status_code
        );

        $this->set_json_content(
            $data,
            $options
        );

        $this->send();
    }


    /**
     * Send JSON success
     *
     * @param mixed $data
     * @param string $message
     * @param int $status_code
     * @return void
     */
    public function send_json_success(
        $data = NULL,
        $message = 'Success',
        $status_code = 200
    )
    {
        $response = array(
            'success' => TRUE,
            'message' => $message,
        );

        if ($data !== NULL)
        {
            $response['data'] = $data;
        }

        $this->send_json(
            $response,
            $status_code
        );
    }


    /**
     * Send JSON error
     *
     * @param string $message
     * @param int $status_code
     * @param array $additional_data
     * @return void
     */
    public function send_json_error(
        $message,
        $status_code = 400,
        $additional_data = array()
    )
    {
        $response = array_merge(
            array(
                'success' => FALSE,
                'error'   => $message,
            ),
            $additional_data
        );

        $this->send_json(
            $response,
            $status_code
        );
    }


    /**
     * Send JSON validation error
     *
     * @param array $errors
     * @param string $message
     * @return void
     */
    public function send_json_validation(
        $errors,
        $message = 'Validation failed'
    )
    {
        $this->send_json_error(
            $message,
            422,
            array(
                'errors' => $errors
            )
        );
    }


    /**
     * Send HTML
     *
     * @param mixed $content
     * @param int $status_code
     * @return void
     */
    public function send_html(
        $content,
        $status_code = 200
    )
    {
        $this->set_status_code(
            $status_code
        );

        $this->set_html_content(
            $content
        );

        $this->send();
    }


    /**
     * Send text
     *
     * @param string $content
     * @param int $status_code
     * @return void
     */
    public function send_text(
        $content,
        $status_code = 200
    )
    {
        $this->set_status_code(
            $status_code
        );

        $this->set_text_content(
            $content
        );

        $this->send();
    }


    /**
     * Send XML
     *
     * @param string $xml
     * @param int $status_code
     * @return void
     */
    public function send_xml(
        $xml,
        $status_code = 200
    )
    {
        $this->set_status_code(
            $status_code
        );

        $this->set_xml_content(
            $xml
        );

        $this->send();
    }


    /**
     * Send 204 No Content
     *
     * @return void
     */
    public function send_no_content()
    {
        $this->set_status_code(204);

        $this->set_content(NULL);

        $this->send();
    }


    /**
     * Send 201 Created
     *
     * @param mixed $data
     * @param string|null $location
     * @return void
     */
    public function send_created(
        $data = NULL,
        $location = NULL
    )
    {
        if ($location !== NULL)
        {
            $this->add_header(
                'Location',
                $location
            );
        }

        $this->send_json_success(
            $data,
            'Created',
            201
        );
    }


    /**
     * Send 401
     *
     * @param string $message
     * @return void
     */
    public function send_unauthorized(
        $message = 'Unauthorized'
    )
    {
        $this->send_json_error(
            $message,
            401
        );
    }


    /**
     * Send 403
     *
     * @param string $message
     * @return void
     */
    public function send_forbidden(
        $message = 'Forbidden'
    )
    {
        $this->send_json_error(
            $message,
            403
        );
    }


    /**
     * Send 404
     *
     * @param string $message
     * @return void
     */
    public function send_not_found(
        $message = 'Not found'
    )
    {
        $this->send_json_error(
            $message,
            404
        );
    }


    /**
     * Send 405
     *
     * @param array $allowed
     * @param string $message
     * @return void
     */
    public function send_method_not_allowed(
        $allowed = array(),
        $message = 'Method not allowed'
    )
    {
        if (!empty($allowed))
        {
            $this->add_header(
                'Allow',
                implode(
                    ', ',
                    array_map(
                        'strtoupper',
                        $allowed
                    )
                )
            );
        }

        $this->send_json_error(
            $message,
            405
        );
    }


    /**
     * Send 429
     *
     * @param string $message
     * @param int|null $retry_after
     * @return void
     */
    public function send_too_many_requests(
        $message = 'Too many requests',
        $retry_after = NULL
    )
    {
        if ($retry_after !== NULL)
        {
            $this->add_header(
                'Retry-After',
                (int) $retry_after
            );
        }

        $this->send_json_error(
            $message,
            429
        );
    }


    /**
     * Send 500
     *
     * @param string $message
     * @return void
     */
    public function send_server_error(
        $message = 'Internal server error'
    )
    {
        $this->send_json_error(
            $message,
            500
        );
    }


    // ---------------------------------------------------------------
    // FILE & STREAMING
    // ---------------------------------------------------------------

    /**
     * Download file
     *
     * @param string $filepath
     * @param string|null $filename
     * @param array $headers
     * @return void
     */
    public function download(
        $filepath,
        $filename = NULL,
        $headers = array()
    )
    {
        if (!file_exists($filepath))
        {
            $this->set_status_code(404)
                ->set_content('File not found')
                ->send();

            return;
        }

        $filename = $filename ?: basename($filepath);
        $filesize = filesize($filepath);

        $this->set_status_code(200);

        $this->add_header(
            'Content-Description',
            'File Transfer'
        );

        $this->add_header(
            'Content-Type',
            mime_content_type($filepath)
        );

        $this->add_header(
            'Content-Disposition',
            'attachment; filename="' . $filename . '"'
        );

        $this->add_header(
            'Content-Transfer-Encoding',
            'binary'
        );

        $this->add_header(
            'Content-Length',
            $filesize
        );

        $this->add_header(
            'Cache-Control',
            'private'
        );

        $this->add_header(
            'Pragma',
            'public'
        );

        $this->add_header(
            'Expires',
            '0'
        );

        foreach (
            $headers
            as $name => $value
        )
        {
            $this->add_header(
                $name,
                $value
            );
        }

        $this->send_headers();

        $handle = fopen(
            $filepath,
            'rb'
        );

        while (!feof($handle))
        {
            echo fread(
                $handle,
                8192
            );

            flush();
        }

        fclose($handle);
    }


    /**
     * Inline file
     *
     * @param string $filepath
     * @param string|null $filename
     * @return void
     */
    public function inline(
        $filepath,
        $filename = NULL
    )
    {
        if (!file_exists($filepath))
        {
            $this->set_status_code(404)
                ->set_content('File not found')
                ->send();

            return;
        }

        $filename = $filename ?: basename($filepath);

        $this->set_status_code(200);

        $this->add_header(
            'Content-Type',
            mime_content_type($filepath)
        );

        $this->add_header(
            'Content-Disposition',
            'inline; filename="' . $filename . '"'
        );

        $this->add_header(
            'Content-Length',
            filesize($filepath)
        );

        $this->add_header(
            'Cache-Control',
            'public, max-age=86400'
        );

        $this->send_headers();

        $handle = fopen(
            $filepath,
            'rb'
        );

        while (!feof($handle))
        {
            echo fread(
                $handle,
                8192
            );

            flush();
        }

        fclose($handle);
    }


    /**
     * Stream
     *
     * @param callable $callback
     * @param array $headers
     * @return void
     */
    public function stream(
        $callback,
        $headers = array()
    )
    {
        if (!is_callable($callback))
        {
            $this->set_status_code(500)
                ->send();

            return;
        }

        $this->add_header(
            'Cache-Control',
            'no-cache'
        );

        foreach (
            $headers
            as $name => $value
        )
        {
            $this->add_header(
                $name,
                $value
            );
        }

        $this->send_headers();

        call_user_func($callback);
    }


    /**
     * Server Sent Events
     *
     * @param callable $callback
     * @return void
     */
    public function send_event_stream(
        $callback
    )
    {
        if (ob_get_level())
        {
            ob_end_clean();
        }

        $this->stream(
            $callback,
            array(
                'Content-Type' =>
                    'text/event-stream',

                'X-Accel-Buffering' =>
                    'no',
            )
        );
    }


    // ---------------------------------------------------------------
    // REDIRECTS
    // ---------------------------------------------------------------

    /**
     * Redirect
     *
     * @param string $url
     * @param int $status_code
     * @return void
     */
    public function redirect(
        $url,
        $status_code = 302
    )
    {
        $valid_codes = array(
            301,
            302,
            303,
            307,
            308
        );

        if (!in_array(
            $status_code,
            $valid_codes
        ))
        {
            $status_code = 302;
        }

        $this->set_status_code(
            $status_code
        );

        $this->add_header(
            'Location',
            $url
        );

        $this->send();

        exit;
    }


    /**
     * Permanent redirect
     *
     * @param string $url
     * @return void
     */
    public function redirect_permanent($url)
    {
        $this->redirect(
            $url,
            301
        );
    }


    /**
     * Redirect after POST
     *
     * @param string $url
     * @return void
     */
    public function redirect_after_post($url)
    {
        $this->redirect(
            $url,
            303
        );
    }


    /**
     * Redirect back
     *
     * @param string $fallback
     * @return void
     */
    public function back(
        $fallback = '/'
    )
    {
        $lava = lava_instance();

        $referrer = isset($lava->request)
            ? $lava->request->referrer()
            : NULL;

        $this->redirect(
            $referrer ?: $fallback
        );
    }


    // ---------------------------------------------------------------
    // COOKIES
    // ---------------------------------------------------------------

    /**
     * Set cookie
     *
     * @param string $name
     * @param string $value
     * @param int $expiration
     * @param string $path
     * @param string $domain
     * @param boolean $secure
     * @param boolean $httponly
     * @param string $samesite
     * @return $this
     */
    public function set_cookie(
        $name,
        $value = '',
        $expiration = 0,
        $path = '',
        $domain = '',
        $secure = FALSE,
        $httponly = FALSE,
        $samesite = 'Lax'
    )
    {
        $this->cookies[] = array(
            'name' =>
                $name,

            'value' =>
                $value,

            'expiration' =>
                $expiration,

            'path' =>
                $path,

            'domain' =>
                $domain,

            'secure' =>
                $secure,

            'httponly' =>
                $httponly,

            'samesite' =>
                $samesite,
        );

        return $this;
    }


    /**
     * Delete cookie
     *
     * @param string $name
     * @param string $path
     * @param string $domain
     * @return $this
     */
    public function delete_cookie(
        $name,
        $path = '',
        $domain = ''
    )
    {
        return $this->set_cookie(
            $name,
            '',
            -3600,
            $path,
            $domain
        );
    }


    // ---------------------------------------------------------------
    // UTILITY
    // ---------------------------------------------------------------

    /**
     * Clear response
     *
     * @return $this
     */
    public function clear()
    {
        $this->status_code  = 200;
        $this->headers      = array();
        $this->content      = NULL;
        $this->cookies      = array();
        $this->headers_sent = FALSE;

        return $this;
    }


    /**
     * Return response as array
     *
     * @return array
     */
    public function to_array()
    {
        return array(
            'status_code' =>
                $this->status_code,

            'status_text' =>
                $this->get_status_text(),

            'headers' =>
                $this->headers,

            'content' =>
                $this->content,
        );
    }


    /**
     * Magic method
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->content;
    }
}