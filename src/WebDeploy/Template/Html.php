<?php
namespace WebDeploy\Template;

class Html
{
    public static function shellResponse($response, $encode = true)
    {
        if (empty($response) || !is_array($response)) {
            return '';
        }

        if (empty($response[0])) {
            $response = array($response);
        }

        $html = '';

        foreach ($response as $values) {
            $html .= '<div class="command">'.self::shellResponseContent($values, $encode).'</div>';
        }

        return $html;
    }

    private static function shellResponseContent(array $values, $encode)
    {
        if ($encode) {
            $values = array_map('self::entities', $values);
        }

        $html = '';

        if (!empty($values['command'])) {
            $html .= '<pre class="bg-dark">$ '.$values['command'].'</pre>';
        }

        if (!empty($values['success'])) {
            $html .= '<pre class="bg-success">'.$values['success'].'</pre>';
        }

        if (!empty($values['error'])) {
            $html .= '<pre class="bg-danger">'.$values['error'].'</pre>';
        }

        return $html;
    }

    public static function entities($html)
    {
        return htmlentities($html, ENT_QUOTES | ENT_IGNORE, 'UTF-8');
    }
}
