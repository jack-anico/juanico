<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

/**
 * BaseController — Parent class for all controllers.
 *
 * Provides shared access to Request and Response objects,
 * plus helper methods for common patterns.
 */
abstract class BaseController
{
    protected Request  $request;
    protected Response $response;

    public function __construct()
    {
        $this->request  = new Request();
        $this->response = new Response();
    }

    /**
     * Redirect back to the previous page with validation errors and old input.
     * Uses the PRG (Post/Redirect/Get) pattern to prevent form resubmission.
     *
     * @param  array $errors Associative array of field => error message
     * @param  array $old    Old form input to repopulate fields
     */
    protected function backWithErrors(array $errors, array $old = []): never
    {
        flash('errors', $errors);
        flash('old', $old);

        $referer = $this->request->server('HTTP_REFERER', url('/'));
        $this->response->redirect($referer);
    }
}
