<ul class="list-unstyled">
	<?php foreach ($products as $product) {?>
	<li>
		<a class="product-name" href="index.php?c=product&a=detail&id=<?=$product->getId()?>" title="<?=$product->getName()?>"><?=$product->getName()?></a>
	</li>
	<?php } ?>
</ul>