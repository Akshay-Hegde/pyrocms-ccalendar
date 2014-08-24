<ol>
  <li class="even">
    <label>Items to display</label>
    <?php echo form_input('limit', $options['limit']) ?>
  </li>
  <li class="odd">
    <label for="color">Color</label>
    <div class="input">
      <label class="radio"><input type="radio" name="color" value="all">&nbsp;All</label>
      <label class="radio"><input type="radio" name="color" value="ffffff">&nbsp;Default</label>
      <label class="radio"><input type="radio" name="color" value="428bca">&nbsp;Primary</label>
      <label class="radio"><input type="radio" name="color" value="dff0d8">&nbsp;Success</label>
      <label class="radio"><input type="radio" name="color" value="d9edf7" checked="checked">&nbsp;Info</label>
      <label class="radio"><input type="radio" name="color" value="fcf8e3">&nbsp;Warning</label>
      <label class="radio"><input type="radio" name="color" value="f2dede">&nbsp;Danger</label>
      <label class="radio"><input type="radio" name="color" value="e6e6e6">&nbsp;Neutral</label>
    </div>
  </li>
</ol>