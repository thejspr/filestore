<h2>Todo list</h2>
<div class="todo-list">
    <ul>
        <li>Login with facebook</li>
        <li>Rename files</li>
        <li>Move files between folders</li>
        <li>Share files with specific user</li>
        <li>HTML5 drag'n'drop upload</li>
        <li>Stylesheet that makes the site more accessible in mobile browsers</li>
        <li>view and edit text based files</li>
        <li>List all public files</li>
        <li>Search files</li>
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
