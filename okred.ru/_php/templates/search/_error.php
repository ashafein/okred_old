<style>
.search_error{
    width: 80%;
    height: 48px;
    border: none;
    padding: 0;
    margin: 0;
}

.search_error img,
.search_error span{
    float: left;
}

.error_text{
    height: 48px;
    line-height: 48px;
    vertical-align: top;
    color: red;
    font-size: 20pt;
    padding: 0;
    margin-left: 10px;
}
</style>
<br><br>
<div class="search_error">
    <img src="_images/error.png" width="48" height="48">
    <span class="error_text"><strong><?php echo htmlspecialchars($errorCode); ?>:</strong> <?php echo htmlspecialchars($errorMessage); ?></span>
</div>