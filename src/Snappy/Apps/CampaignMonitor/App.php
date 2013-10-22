<?php namespace Snappy\Apps\CampaignMonitor;

use Snappy\Apps\ContactCreatedHandler;
use Snappy\Apps\App as BaseApp;

class App extends BaseApp implements ContactCreatedHandler {

	/**
	 * The name of the application.
	 *
	 * @var string
	 */
	public $name = 'Campaign Monitor';

	/**
	 * The application description.
	 *
	 * @var string
	 */
	public $description = 'Automatically add contacts to a Campaign Monitor list';

	/**
	 * Any notes about this application
	 *
	 * @var string
	 */
	public $notes = '
		<p>To get your API token visit you Account Settings -> show api key.</p>
		<p>To get your list id login to your CampaignMonitor account then go to Lists &amp; Subscribers -> Select List -> change name/type. The API
		Subscriber List ID will be at the bottom of this page.</p>
	';

	/**
	 * The application's icon filename.
	 *
	 * @var string
	 */
	public $icon = 'campaignmonitor.png';

	/**
	 * The application service's main website.
	 *
	 * @var string
	 */
	public $website = 'https://campaignmonitor.com';

		/**
	 * The application author name.
	 *
	 * @var string
	 */
	public $author = 'UserScape, Inc.';

	/**
	 * The application author e-mail.
	 *
	 * @var string
	 */
	public $email = 'it@userscape.com';

	/**
	 * The settings required by the application.
	 *
	 * @var array
	 */
	public $settings = array(
		array('name' => 'token', 'type' => 'text', 'help' => 'Enter your API Token', 'validate' => 'required'),
		array('name' => 'list', 'type' => 'text', 'help' => 'Enter your Email List ID', 'validate' => 'required'),
	);

	/**
	 * Add the contact into a Campaign Monitor List
	 * @param  array  $ticket
	 * @param  array  $contact
	 * @return void
	 */
	public function handleContactCreated(array $ticket, array $contact)
	{
		$client = $this->getClient();
		$client->add(array(
  		'EmailAddress' => $contact['value'],
  		'Name' => $contact['first_name']. ' '. $contact['last_name'],
		));
	}

	/**
	 * Get the client instance
	 *
	 * @return \CS_REST_Subscribers
	 */
	protected function getClient()
	{
		$client = new \CS_REST_Subscribers($this->config['list'], array('api_key' => $this->config['token']));

		return $client;
	}
}
