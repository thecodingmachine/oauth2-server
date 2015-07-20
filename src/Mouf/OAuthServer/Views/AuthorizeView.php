<?php
namespace Mouf\OAuthServer\Views;

use Mouf\Html\HtmlElement\HtmlBlock;

use Mouf\Html\HtmlElement\HtmlElementInterface;

use Mouf\Html\Template\TemplateInterface;

use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\Html\Renderer\Renderable;
use League\OAuth2\Server\Entity\ScopeEntity;



/**
 * The view for the login screen.
 * 
 * @author Marc TEYSSIER
 * @Component
 */
class AuthorizeView implements HtmlElementInterface {
	use Renderable;
	/**
	 * The label for the "login" field.
	 *
	 * @Property
	 * @var string|ValueInterface
	 */
	public $clientName = '';
	
	/**
	 * The label for the "password" field.
	 *
	 * @Property
	 * @var <ScopeEntity>
	 */
	public $scopes = [];
}