<tr id="image-<?=$imageObj->getId();?>" class="template-download fade in">
   	<td>
      	<span class="preview">                        
        <a href="<?=$imageObj->getImageUrl();?>" title="<?=$imageObj->getTitle();?>" download="<?=$imageObj->getTitle();?>" data-gallery="">
        <img src="<?=$imageObj->getImageUrl();?>" style="width:120px;"></a>    
       	</span>
   	</td>
  	<td>
      	<p class="name"><strong><?=$imageObj->getTitle();?></strong></p>
   	</td>
	<td align="right">
      	<button class="image-delete btn red btn-sm" data-id="<?=$imageObj->getId();?>" data-url="<?= PATH;?>gallery/delete/<?=$imageObj->getId();?>">
        <i class="fa fa-trash-o"></i>
        <span>Delete</span>
        </button>
<!--
        <input name="delete[]" value="<?=$imageObj->getId();?>" class="toggle" type="checkbox">
-->
  	</td>
</tr>
