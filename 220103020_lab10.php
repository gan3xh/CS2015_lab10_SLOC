<?php
function wordCount($line)
{
  return count(explode(" ", $line));
}

function charCount($line)
{
  $char_count = strlen($line);
  $char_count_without_spaces = strlen(str_replace(' ', '', $line));
  return array($char_count, $char_count_without_spaces);
}


function WCSimulation($html_file)
{
  $total_tokens = 0;
  $total_characters = 0;
  $total_characters_without_spaces = 0;
  $elements = array();
  $file = fopen($html_file, "r");

  if ($file) {
    while (($line = fgets($file)) !== false) {
      $tokens = str_word_count($line);
      $total_tokens += $tokens;
      list($characters, $characters_without_spaces) = charCount($line);
      $total_characters += $characters;
      $total_characters_without_spaces += $characters_without_spaces;

      preg_match_all('/<([a-zA-Z][a-zA-Z0-9]*)\b[^>]*>/', $line, $matches);
      foreach ($matches[1] as $tag_name) {
        if (!isset($elements[$tag_name])) {
          $elements[$tag_name] = 0;
        }
        $elements[$tag_name]++;
      }
    }

    echo "Total Tokens: $total_tokens <br>";
    echo "Total Characters (with spaces): $total_characters <br>";
    echo "Total Characters (without spaces): $total_characters_without_spaces <br>";
    echo "<h2>HTML Element Counts</h2>";
    echo "<table>";
    echo "<tr><th>Element Name</th><th>Count</th></tr>";
    foreach ($elements as $element => $count) {
      echo "<tr><td>$element</td><td>$count</td></tr>";
    }
    echo "</table>";

    fclose($file);
  } else {
    echo "Error opening the file.";
  }
}


function countUserDefinedFunctions($php_code)
{
  $functions = array();
  $matches = array();
  preg_match_all('/function\s+([^\s\(]+)/', $php_code, $matches);

  foreach ($matches[1] as $function_name) {
    if (!isset($functions[$function_name])) {
      $functions[$function_name] = 0;
    }
    $functions[$function_name]++;
  }

  return $functions;
}

function calculateHalsteadMetrics($php_code)
{
  $operators = array('+', '-', '*', '/', '%', '=', '>', '<', '!', '&&', '||', '==', '!=', '>=', '<=', '++', '--', '.=', '+=', '-=', '*=', '/=', '%=', '?:');
  $operators_count = array();
  $operands_count = array();

  $tokens = token_get_all($php_code);

  foreach ($tokens as $token) {
    if (is_array($token)) {
      $token_type = $token[0];
      $token_value = $token[1];

      if (in_array($token_value, $operators)) {
        if (!isset($operators_count[$token_value])) {
          $operators_count[$token_value] = 0;
        }
        $operators_count[$token_value]++;
      } elseif (in_array($token_type, [T_VARIABLE, T_STRING, T_CONSTANT_ENCAPSED_STRING, T_LNUMBER, T_DNUMBER])) {
        if (!isset($operands_count[$token_value])) {
          $operands_count[$token_value] = 0;
        }
        $operands_count[$token_value]++;
      }
    }
  }

  $n1 = count($operators_count);
  $N1 = array_sum($operators_count);
  $n2 = count($operands_count);
  $N2 = array_sum($operands_count);
  $n = $n1 + $n2;
  $N = $N1 + $N2;
  $V = $N * log($n, 2);
  $D = ($n1 / 2) * ($N2 / $n2);
  $E = $D * $V;

  return array(
    'vocabulary' => $n,
    'length' => $N,
    'volume' => $V,
    'difficulty' => $D,
    'effort' => $E
  );
}

function calculateCyclomaticComplexity($php_code)
{
  $complexity = 1;
  $tokens = token_get_all($php_code);

  foreach ($tokens as $token) {
    if (is_array($token)) {
      $token_type = $token[0];
      if (T_IF == $token_type || T_FOR == $token_type || T_FOREACH == $token_type || T_WHILE == $token_type || T_SWITCH == $token_type || T_CASE == $token_type) {
        $complexity++;
      }
    }
  }

  return $complexity;
}

if (isset($_FILES["html_file"]["tmp_name"])) {
  $htmlFilePath = $_FILES["html_file"]["tmp_name"];

  $fileType = strtolower(pathinfo($_FILES["html_file"]["name"], PATHINFO_EXTENSION));
  if ($fileType === 'html') {
    WCSimulation($htmlFilePath);

    $php_code = file_get_contents("220103020_lab10.php");

    $userDefinedFunctions = countUserDefinedFunctions($php_code);

    echo "<h2>User-defined Function Count:</h2>";
    echo "<table>";
    echo "<tr><th>User-defined Function Name</th><th>Call Count</th></tr>";
    foreach ($userDefinedFunctions as $function_name => $call_count) {
      echo "<tr><td>$function_name</td><td>$call_count</td></tr>";
    }
    echo "</table>";

    $halsteadMetrics = calculateHalsteadMetrics($php_code);
    echo "Halstead Metrics: <pre>" . print_r($halsteadMetrics, true) . "</pre>";

    $cyclomaticComplexity = calculateCyclomaticComplexity($php_code);
    echo "Cyclomatic Complexity: $cyclomaticComplexity";
  } else {
    echo "Upload an HTML file";
  }
}
