# Word Count and Code Analysis

This PHP script provides functionality to count words, characters, and HTML elements in an uploaded HTML file. Additionally, it performs code analysis on itself, including counting user-defined functions, calculating Halstead metrics, and determining cyclomatic complexity.

# About
This project is a lab assignment for the course Web Technology (CS2015) taught by Dr Navanath Saharia at the Indian Institute of Information Technology (IIIT), Manipur. It is designed to demonstrate the practical application of web development technologies like HTML, CSS, and PHP.

## Features

1. **Word and Character Count**: The script counts the total number of words (tokens) and characters (with and without spaces) in the uploaded HTML file.

2. **HTML Element Counting**: It counts the occurrences of each HTML element present in the uploaded file.

3. **User-defined Function Counting**: The script analyzes its own code and counts the number of times each user-defined function is called.

4. **Halstead Metrics**: It calculates the Halstead metrics, including vocabulary, length, volume, difficulty, and effort, for the PHP code.

5. **Cyclomatic Complexity**: The script determines the cyclomatic complexity of its own code, which is a measure of the complexity of the control flow.

## Usage

1. Upload an HTML file using the provided form.
2. Click the "Submit" button.
3. The script will process the uploaded file and display the following information:
  - Total word count (tokens)
  - Total character count (with and without spaces)
  - HTML element counts in a table
  - User-defined function call counts in a table
  - Halstead metrics
  - Cyclomatic complexity

## Requirements

- PHP 5.4 or higher
- A web server with PHP support

## Notes

- The script only accepts HTML files for the word count and element counting functionality.
- The code analysis features (user-defined function counting, Halstead metrics, cyclomatic complexity) are performed on the script itself.
- Ensure that the script file (`220103020_lab10.php`) is in the same directory as the HTML file being uploaded.
