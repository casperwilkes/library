<?php

/*
 * say() is a utility function for inspecting strings, variables, and arrays.
 * @usage
 * To echo a string, object, or array, use: say($input);
 * To echo a clean looking backtrace, simply use: say();
 * To echo a say(); and die();, use sayd() the same way.
 * You can be all like say('$var_name', $var, 'tag_it');
 * Backtraces are saved in php_errors.log AND say.log.
 * @param mixed $input The input to inspect.
 * @param string $tag An optional display tag.
 * @return void
 * @author Drew Brown <dbrown@clacorp.com>
 */

// define('SAY_LOG', '/home/developer/say.log');

function say() {
    global $say_count, $sayd_arguments;
    // 2DO . . . Return FALSE if not in a development environment
    // Increment a count to help differentiate the say() outputs.
    $say_count++;

    // Generate a backtrace with the path, class, file, function, arguments, and objects.
    list( $backlog, $pretty, $called_from) = backtrace();
    // print_r($backlog); die();
    // Add the backtrace to say.log AND php_errors.log
    say_log($backlog, $pretty);

    // If sayd(); did not provide any arguments, get them
    $arguments = (!$sayd_arguments) ? func_get_args() : $sayd_arguments;

    $display = display($arguments, $say_count, $called_from);

    if(!defined('SAYS')) {
    echo $display;
    }
}

function sayd() {
    global $sayd_arguments;
    define('SAYD', TRUE);
    // Use sayd($arguments); to output say(); and die();
    $sayd_arguments = func_get_args();
    say();
    die();
}

function says() {
    global $sayd_arguments;
    define('SAYD', TRUE);
    define('SAYS', TRUE);
    // Use sayd($arguments); to output say(); and die();
    $sayd_arguments = func_get_args();
    say();
}

function display($arguments, $say_count, $called_from) {
    global $say_count, $sayd_arguments;
    $call = (defined('SAYD')) ? "<font color=red>sayd($say_count)</font>" : "say($say_count)";

    // Display Header
    $header = '<div style="margin: 1em 0;"><fieldset style="display:inline-block;padding:0em 3em 1em 1em;">';
    $header .= '<legend><b>' . $call . '</b>: ' . count($arguments) . ' arguments | ' . $called_from . '</legend>';

    // Display Body
    if ($arguments) {
        $body = "<pre><p>";
        foreach ($arguments as $arg) {
            switch (gettype($arg)) {
                case "boolean":
                case "integer":
                    $body .= "<b>" . gettype($arg) . ":</b> " . json_encode($arg);
                    break;
                case "string":
                    $body .= "<b>" . gettype($arg) . ":</b> $arg";
                    break;
                default:
                    $body .= "<b>" . gettype($arg) . ":</b><p>";
                    ob_start();
                    var_dump($arg);
                    $body .= ob_get_clean();
                    if (ob_get_length())
                        ob_end_clean();
                    $body .= '</p>';
            }
            $body .= '</p></pre>';
        }
    } else {
        $pretty_backtrace = file_get_contents(SAY_LOG);
        $body = '<pre>' . $pretty_backtrace . '</pre>';
    }

    // Display Footer
    $footer = (defined('SAYD')) ? "#jumptag </legend> <font color=red>die()</font></div>" : '#jumptag</fieldset></div>';
    // echo "<br><br>$say_tag || <strong>path:</strong> $path || <strong>line:</strong> $line || ###<hr>";
    // echo "<font color=red>sayd() die()</font><hr color=red>";
    return $header . $body . $footer;
}

function backtrace() {
    $backlog = array();
    $pretty = array();
    $backtrace = debug_backtrace();
    foreach ($backtrace AS $trace) {
        $i++;
        if (basename($trace['file']) !== 'say.php') {
            if (isset($trace['function'])) {
                $function = $trace['function'] . "()";
            } else {
                unset($function);
            }
            if (isset($trace['file'])) {
                $backlog[$i]['path'] = $trace['file'];
                $pretty[$i]['path'] = $trace['file'];
                //$called_from = (  )
            }
            if (isset($trace['class']) && !empty($trace['class']) && isset($function)) {
                $backlog[$i]['class_function'] = $trace['class'] . "->" . $function;
                $pretty[$i]['class_function'] = $trace['class'] . "->" . $function;
            } else {
                $backlog[$i]['class_function'] = $function;
                $pretty[$i]['class_function'] = $function;
            }

            if (isset($trace['line'])) {
                $backlog[$i]['line'] = $trace['line'];
                $pretty[$i]['line'] = $trace['line'];
            }

            if (isset($trace['args'])) {
                $backlog[$i]['args'] = json_encode($trace['args']);
                $pretty[$i]['args'] = format_json($backlog[$i]['args']);
            }

            if (isset($trace['object']) && !empty($trace['object'])) {
                $backlog[$i]['object'] = json_encode($trace['object']);
                $pretty[$i]['object'] = format_json($backlog[$i]['object']);
            }
        }
    }
    // Arrange the backtrace in chronological order
    $backlog = array_reverse($backlog);
    $pretty = array_reverse($pretty);
    $trace_count = count($backlog) - 1;
    $called_from = $pretty[$trace_count]['path'] . ' | line ' . $pretty[$trace_count]['line'];

    // echo $trace_count; die();
    // echo $called_from; die();
    // $backlog_count = count($backlog) - 1; echo $backlog_count; die();
    // echo "<pre>"; print_r($backlog); die();
    // echo "<pre>"; print_r($pretty); die();
    return array($backlog, $pretty, $called_from);
}

function say_log($backlog, $pretty) {
    // Check to see if a log path has been set.
    // If not, set it to the location of say.php
    defined('SAY_LOG') or define('SAY_LOG', __DIR__ . '/say.log');

    // Delete the say.log before each run to make it easy to read.
    if(file_exists(SAY_LOG)) {
    unlink(SAY_LOG);
    }

    foreach ($pretty AS $index => $trace) {
        $log = $index + 1 . ". ";
        $log .= ( isset($pretty[$index]['path']) ) ? $pretty[$index]['path'] . " | line: " . $pretty[$index]['line'] . PHP_EOL : '';
        $log .= $pretty[$index]['class_function'] . PHP_EOL . $pretty[$index]['args'] . $pretty[$index]['object'] . PHP_EOL . PHP_EOL;

        // Add the output to the php_errors.php log
        error_log($log);

        // Add another copy to a say error log
        file_put_contents(SAY_LOG, "$log", FILE_APPEND);
    }
}

function format_json($json) {
    $tab = "  ";
    $new_json = "";
    $indent_level = 0;
    $in_string = false;

    $json = trim($json);
    $json = utf8_encode($json);
    $json_obj = json_decode($json);

    if ($json_obj === FALSE) {
        return FALSE;
    }

    $json = json_encode($json_obj);
    $len = strlen($json);

    for ($c = 0; $c < $len; $c++) {
        $char = $json[$c];
        switch ($char) {
            case '{':
            case '[':
                if (!$in_string) {
                    $new_json .= $char . "\n" . str_repeat($tab, $indent_level + 1);
                    $indent_level++;
                } else {
                    $new_json .= $char;
                }
                break;
            case '}':
            case ']':
                if (!$in_string) {
                    $indent_level--;
                    $new_json .= "\n" . str_repeat($tab, $indent_level) . $char;
                } else {
                    $new_json .= $char;
                }
                break;
            case ',':
                if (!$in_string) {
                    $new_json .= ",\n" . str_repeat($tab, $indent_level);
                } else {
                    $new_json .= $char;
                }
                break;
            case ':':
                if (!$in_string) {
                    $new_json .= ": ";
                } else {
                    $new_json .= $char;
                }
                break;
            case '"':
                if ($c > 0 && $json[$c - 1] != '\\') {
                    $in_string = !$in_string;
                }
            default:
                $new_json .= $char;
                break;
        }
    }

    // Strip out the ugly characters to make the JSON easier on the eyes
    $new_json = str_replace("{", "", $new_json);
    $new_json = str_replace("},", "", $new_json);
    $new_json = str_replace("}", "", $new_json);
    $new_json = str_replace("\"", "", $new_json);
    $new_json = str_replace(",", "", $new_json);
    $new_json = str_replace("\\/", "/", $new_json);

    return $new_json;
}

?>
