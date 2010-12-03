<h1>Todo list</h1>
<div class="todo-list">
    <ul>
        <li>Login with facebook</li>
        <li>HTML5 drag'n'drop upload</li>
        <li>Stylesheet for mobile browsers</li>
        <li>Search files</li>
        <li>File encryption option</li>
    </ul>
</div>
<br/>
<h3>Changelog:</h3>
<div class="changelog">
<?
$file_path = "changelog";
if (file_exists($file_path)) {
    $file = fopen($file_path, 'r');
    $first = true;

    while(!feof($file)) {
        $line = fgets($file);
        if (!stristr($line,"=") && !$first)
            echo "<br/>";
        echo $line;
        $first = false;
    }

    fclose($file);

} else {
    echo "<i>Changelog not available</i>";
}
?>
</div>
<br />
