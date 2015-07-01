<?php namespace glue;

class ErrorHandler{
    public static function logger($num, $str, $file, $line, $context = null ){
        // Use of WP_DEBUG as temporarly toggle method
        if( WP_DEBUG ){
            $exception = new \ErrorException( $str, 0, $num, $file, $line );
            echo self::get_message( $exception );
        }
        return true;
    }

    public static function get_message( \ErrorException $exception ){
        $header_style = "color: #a94442; background-color: #f2dede; border: 1px solid #ebccd1; border-bottom: none; padding: 10px; text-align: center; margin-top: 20px;";
        $message = <<<MESSAGE
<div style="$header_style">
    <h2 style="font-size: 20px; font-weight: bold; margin: 0; padding: 0;line-height: 100%;">Exception Occured:</h2>
</div>
<div style="max-width: 100%; width: 100%; margin: 0; padding: 0;">
    <table style='margin: 0; padding: 0' border="0">
        <tr style=''>
            <th>Message</th>
            <td>{$exception->getMessage()}</td>
        </tr>
        <tr style=''>
            <th>File</th><td>{$exception->getFile()}</td>
        </tr>
        <tr style=''>
            <th>Line</th><td>{$exception->getLine()}</td>
        </tr>
    </table>
</div>
<div style="text-align: right; padding-top: 5px; margin-bottom: 20px;">
    Glue by Moxie.
</div>
MESSAGE;
        return $message;
    }
}

