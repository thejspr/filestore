<h2>Todo list</h2>

<p>This is a list of tasks, past and present, for FileStore:</p>
<div style="margin-left: 50px;">
    <ul>
        <li class="done">view uploaded images</li>
        <li>Login with facebook</li>
        <li>Share files with specific user</li>
        <li>HTML5 drag'n'drop upload</li>
        <li class="done">Delete all files and folders on profile deletion</li>
        <li>Stylesheet that makes the site more accessible in mobile browsers</li>
        <li>view and edit text based files</li>
    </ul>
</div>
<br/>
<h3>Changelog:</h3>
<?
$file_path = "changelog.log";
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