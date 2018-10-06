<p><b>{$ad->icon} {$ad->title}</b></p>

{if $ad->image}
	{img src="{$ad->image}" alt="Imagen del producto o servicio" width="100%"}
	{space5}
{/if}

<small><p style="color:grey;">Publicado: {$ad->inserted}</p></small>

<p>{nl2br($ad->description)}</p>

{space10}

<center>
	{button href="PUBLICIDAD" caption="M&aacute;s anuncios"}
</center>
