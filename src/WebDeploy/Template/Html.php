<?php
namespace WebDeploy\Template;

use WebDeploy\Router;
use WebDeploy\Exception;

class Html
{
    public static function shellResponse($response)
    {
        if (empty($response) || !is_array($response)) {
            return '';
        }

        if (empty($response[0])) {
            $response = array($response);
        }

        $html = '';

        foreach ($response as $values) {
            if (empty($values['command'])) {
                continue;
            }

            $html .= '<div class="command">';
            $html .= '<pre>$ '.$values['command'].'</pre>';

            if ($values['success']) {
                $html .= '<pre class="bg-success">'.$values['success'].'</pre>';
            }

            if ($values['error']) {
                $html .= '<pre class="bg-danger">'.$values['error'].'</pre>';
            }

            $html .= '</div>';
        }

        return $html;
    }
}
