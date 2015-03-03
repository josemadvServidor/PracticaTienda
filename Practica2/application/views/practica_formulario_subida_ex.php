<h1>Menu de importacion XML</h1>
<p>Seleccione el archivo:</p>
<?=form_open_multipart('/upload/do_uploadex')?>
<input type="file" name="archivo" />
<br /><br />
<input type="submit" value="Subir" />
</form>