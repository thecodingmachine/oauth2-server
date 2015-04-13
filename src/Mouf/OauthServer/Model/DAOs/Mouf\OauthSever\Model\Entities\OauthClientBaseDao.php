<?php
/*
* This file has been automatically generated by Mouf/ORM.
* DO NOT edit this file, as it might be overwritten.
* If you need to perform changes, edit the Mouf\OauthSever\Model\Entities\OauthClientDao class instead!
*/
namespace Mouf\OauthServer\Model\DAOs;

use Mouf\Database\DAOInterface;
use Mouf\Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Mouf\OauthSever\Model\Entities\OauthClient;

/**
* The Mouf\OauthSever\Model\Entities\OauthClientBaseDao class will maintain the persistance of Mouf\OauthSever\Model\Entities\OauthClient class into the oauth_clients table.
*
*/
class Mouf\OauthSever\Model\Entities\OauthClientBaseDao extends EntityRepository implements DAOInterface {

	/**
	 * @param EntityManager $entityManager
	 */
	public function __construct($entityManager){
		parent::__construct($entityManager, $entityManager->getClassMetadata('Mouf\OauthSever\Model\Entities\OauthClient'));
	}


	/**
	 * Get a new bean record
	 * * @return Mouf\OauthSever\Model\Entities\OauthClient the new bean object
	 */
	public function create(){
		return new Mouf\OauthSever\Model\Entities\OauthClient();
	}

	/**
	 * Get a bean by it's Id
	 * @param mixed $id
	 * @return Mouf\OauthSever\Model\Entities\OauthClient the bean object
	 */
	public function getById($id){
		return $this->find($id);
	}

	/**
	 *
	 * Peforms saving on a bean object
	 * @param mixed bean object
	 */
	public function save($entity){
		$this->getEntityManager()->persist($entity);
	}

	/**
	 * Returns the lis of beans
	 * @return array[Mouf\OauthSever\Model\Entities\OauthClient] array of bean objects
	 */
	public function getList(){
		return $this->findAll();
	}

	/**
     * Finds only one entity. The criteria must contain all the elements needed to find a unique entity.
     * Throw an exception if more than one entity was found.
     *
     * @param array $criteria
     *
     * @return Mouf\OauthSever\Model\Entities\OauthClient the bean object
     */
    public function findUniqueBy(array $criteria)
    {
        $result = $this->findBy($criteria);

        if(count($result) == 1){
            return $result[0];
        }elseif(count($result) > 1){
            throw new NonUniqueResultException('More than one Mouf\OauthSever\Model\Entities\OauthClient was found');
        }else{
           return null;
        }
    }

	
	/**
	 * Wrapper around the magic __call implementations of the findBy[Field] function to get autocompletion
	 * @param mixed $fieldValue the value of the filtered field
	 * @param array|null $orderBy the value of the filtered field
	 * @param int|null $limit the max elements to be returned
	 * @param int|null $offset the index of the first element to retrieve
	 * @return Mouf\OauthSever\Model\Entities\OauthClient[]
	 */
	public function findBySecret($fieldValue, $orderBy = null, $limit = null, $offset = null) {
		return $this->findBy(array('secret' => $fieldValue), $orderBy, $limit, $offset);
	}

	/**
	 * Wrapper around the magic __call implementations of the findByOne[Field] function to get autocompletion
	 * @param mixed $fieldValue the value of the filtered field
	 * @param array|null $orderBy the value of the filtered field
	 * @return Mouf\OauthSever\Model\Entities\OauthClient
	 */
	public function findOneBySecret($fieldValue, $orderBy = null) {
		return $this->findOneBy(array('secret' => $fieldValue), $orderBy);
	}

	/**
	 * Finds only one entity by Secret.
     * Throw an exception if more than one entity was found.
	 * @param mixed $fieldValue the value of the filtered field
	 * @return Mouf\OauthSever\Model\Entities\OauthClient
	 */
	public function findUniqueBySecret($fieldValue) {
		return $this->findUniqueBy(array('secret' => $fieldValue));
	}
	/**
	 * Wrapper around the magic __call implementations of the findBy[Field] function to get autocompletion
	 * @param mixed $fieldValue the value of the filtered field
	 * @param array|null $orderBy the value of the filtered field
	 * @param int|null $limit the max elements to be returned
	 * @param int|null $offset the index of the first element to retrieve
	 * @return Mouf\OauthSever\Model\Entities\OauthClient[]
	 */
	public function findByName($fieldValue, $orderBy = null, $limit = null, $offset = null) {
		return $this->findBy(array('name' => $fieldValue), $orderBy, $limit, $offset);
	}

	/**
	 * Wrapper around the magic __call implementations of the findByOne[Field] function to get autocompletion
	 * @param mixed $fieldValue the value of the filtered field
	 * @param array|null $orderBy the value of the filtered field
	 * @return Mouf\OauthSever\Model\Entities\OauthClient
	 */
	public function findOneByName($fieldValue, $orderBy = null) {
		return $this->findOneBy(array('name' => $fieldValue), $orderBy);
	}

	/**
	 * Finds only one entity by Name.
     * Throw an exception if more than one entity was found.
	 * @param mixed $fieldValue the value of the filtered field
	 * @return Mouf\OauthSever\Model\Entities\OauthClient
	 */
	public function findUniqueByName($fieldValue) {
		return $this->findUniqueBy(array('name' => $fieldValue));
	}
}