<h2>Todo list</h2>

<p>This is a list of tasks, past and present, for this app?</p>
<br />
<div style="margin-left: 50px;">
    <ul>
        <li class="done">view images</li>
        <li>login with facebook</li>
        <li>Drag/drop upload</li>
        <li class="done">Delete all files and folders when profile deletion</li>
        <li>Stylesheet that makes the site more accessible in mobile browsers</li>
    </ul>
</div>
<br/><br/>
<?
$file_path = "changelog.log";
if (file_exists($file_path)) {
    $file = fopen($file_path, 'r');
    
    while(!feof($file)) {
      echo fgets($file). "<br />";
    }

    fclose($file);

} else {
    echo "<i>Changelog not available</i>";
}
?>