<?php

class Publicidad extends Service
{
	/**
	 * Show the list of ads
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function _main(Request $request)
	{
		// get all running ads
		$ads = Connection::query("
			SELECT id, icon, title
			FROM ads
			WHERE active=1
			AND (expires IS NULL OR expires > CURRENT_TIMESTAMP)
			ORDER BY paid DESC, inserted DESC
			LIMIT 20");

		// if there are no ads
		if (empty($ads)) {
			$response = new Response();
			$response->setResponseSubject("No tenemos ninguna propuesta por ahora");
			$response->createFromText("Lo sentimos mucho, pero en estos momentos no tenemos ninguna propuesta en su &aacute;rea. Estamos trabajando en incrementar nuestra lista de propuestas para que nunca m&aacute;s vea este mensaje. Por favor vuelva en unos d&iacute;as a ver que encontramos.");
			return $response;
		}

		// create the response
		$response = new Response();
		$response->setResponseSubject("Propuestas para usted");
		$response->createFromTemplate("all.tpl", array("ads" => $ads));
		return $response;
	}

	/**
	 * Show one ad
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function _ver(Request $request)
	{
		// check if there is any valid id passed
		$adId = intval($request->query);
		$ad = Connection::query("
			SELECT id, icon, title, description, image, inserted 
			FROM ads 
			WHERE id=$adId 
			AND active=1 
			AND (expires IS NULL OR expires > CURRENT_TIMESTAMP)");

		// if there are no ads
		if (empty($ad)) {
			$response = new Response();
			$response->setResponseSubject("El anuncio que busca no existe");
			$response->createFromText("Lo sentimos mucho, pero el anuncio que usted busca no existe, o ha expirado. Por favor revise que el numero del anuncio este correcto e intente nuevamente.");
			return $response;
		}

		// get a path to the root folder
		$di = \Phalcon\DI\FactoryDefault::getDefault();
		$wwwroot = $di->get('path')['root'];

		// get the image if it exists
		$ad = $ad[0];
		$imageArr = [];
		if($ad->image) {
			$imageFile = "$wwwroot/public/ads/".$ad->image;
			if(file_exists($imageFile)) $imageArr = [$imageFile];
		}

		// add a click for the ad
		Connection::query("UPDATE ads SET clicks=clicks+1 WHERE id={$ad->id}");

		// create the response
		$response = new Response();
		$response->setCache();
		$response->setResponseSubject($ad->title);
		$response->createFromTemplate("one.tpl", ["ad"=>$ad], $imageArr);
		return $response;
	}

	/**
	 * Subservice PUBLICAR
	 *
	 * @param Request $request
	 */
	public function _publicar($request)
	{
		// get title and body
		$title = Connection::escape($request->params[0], 40);
		$body = Connection::escape($request->params[1], 500);
		if (empty($title)) $title = trim(substr($body, 0, 40));
		if (empty($title)) return new Response();

		// get date a month from now
		$expires = date("Y-m-d H:i:s", strtotime("+1 months"));

		// insert the ad in the database
		$id = Connection::query("
			INSERT INTO ads (owner,title,description,expires,paid)
			VALUES ('{$request->email}','$title','$body','$expires',0)");

		// respond to the owner of the ad
		$response = new Response();
		$response->setResponseSubject("Su anuncio ha sido publicado");
		$response->createFromTemplate('publish.tpl', ['id'=>$id]);
		return $response;
	}
}
