<h1>Propuestas para usted</h1>

{space10}

{foreach from=$ads item=ad name=ads}
	<table width="100%" border=0  bgcolor="#C3DAEE">
		<tr>
			<td valign="middle"><b>{$ad->icon}</b> {$ad->title}</td>
			<td align="right">{button href="PUBLICIDAD VER {$ad->id}" caption="&#9758; Leer m&aacute;s" size="small"}</td>
		</tr>
	</table>
	{space5}
{/foreach}

<center>
	{button href="PUBLICIDAD PUBLICAR" desc="t:Titulo (40 caracteres)|a:Cuerpo (500 caracteres)" popup="true" caption="Publicar"}
</center>
