symfony_sonata_project
======================

A Symfony project created on October 25, 2017, 2:05 am.

# Symfony PHP Framework

## Installer Composer
 https://getcomposer.org/doc/00-intro.md

 
## Via Composer Create-Project

  ### composer create-project symfony/framework-standard-edition symfony_sonata_project 2.8.3 
  ### or php composer.phar create-project symfony/framework-standard-edition symfony_sonata_project 2.8.3 
  
  ###$ cd symfony-symfony_sonata_project/
  
  ###$ php app/console server:run
  
    http://localhost:8000/

## Installer Symfony
 
### linux and mac
 sudo mkdir -p /usr/local/bin
 sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
 sudo chmod a+x /usr/local/bin/symfony

### windows
 php -r "file_put_contents('symfony', file_get_contents('https://symfony.com/installer'));"


 
## Via Composer Create-Project

  ### symfony new symfony_sonata_project 2.8.3
  
  ###$ cd symfony-symfony_sonata_project/
  
  ###$ php app/console server:run
  
    http://localhost:8000/
    
## Configuration du serveur web - Bonne pratique

### httpd-vhosts.conf  file
### C:\wamp64\bin\apache\apache2.4.23\conf\extra\httpd-vhosts.conf
      
```
<VirtualHost *:80>
	 
	 <VirtualHost *:80>
		ServerName job.dev
		DocumentRoot C:/github/symfony_sonata_project/web
		DirectoryIndex app.php
		#ErrorLog /var/log/apache2/job-error.log
		#CustomLog /var/log/apache2/job-access.log combined
		<Directory "C:/github/symfony_sonata_project/web">
		    # Apache 2.4
            Require all granted
		   
		    ## Apache 2.2
			AllowOverride All
			Allow from All
		</Directory>
</VirtualHost>
```



###	hosts file
### C:\Windows\System32\drivers\etc

```
127.0.0.1   job.dev
```
	
http://job.dev/
http://job.dev/app_dev.php
http://job.dev/config.php
	
	
## La console Symfony2
```
php app/console list
```

## 1- Création du paquet Application (Bundle)
```
php app/console generate:bundle --namespace=Selmi/JobBundle --format=yml
```

### Bundle namespace [Selmi/JobBundle]: Selmi/JobBundle
### Bundle name [SelmiJobBundle]: SelmiJobBundle
### Bundle name [SelmiJobBundle]: SelmiJobBundle
### Configuration format (yml, xml, php, or annotation) [yml]: yml


## 2- Videz le cache après avoir créé le nouveau paquet avec:

```
php app/console cache:clear --env=prod
php app/console cache:clear --env=dev
```

## 3- La Base De Données
### Pour définir les paramètres de connexion, vous devez éditer le fichier app/config/parameters.ini 
```
;app/config/parameters.ini
[parameters]
    database_driver   = pdo_mysql
    database_host     = localhost
    database_name     = symfony-job
    database_user     = root
    database_password = password
```

### Maintenant que Doctrine connaît votre BDD, vous pouvez l'utiliser pour créer la BDD pour vous (si vous ne l'avez pas déjà créée):

```
php app/console doctrine:database:create
```

## 4- L'ORM
### Le rôle d'un ORM est de se charger de la persistance de vos données : vous manipulez des objets, et lui s'occupe de les  enregistrer en base de données.
### L'ORM par défaut livré avec Symfony2 est Doctrine2.

### Le schéma
### Pour que Doctrine connaisse nos objets, nous allons créer des fichiers "métadonnées" qui décrivent la façon dont nos objets seront stockés dans la BDD
### src/Selmi/JobBundle/Resources/config/doctrine/Job.orm.yml
### src/Selmi/JobBundle/Resources/config/doctrine/Affiliate.orm.yml
### src/Selmi/JobBundle/Resources/config/doctrine/Category.orm.yml
### src/Selmi/JobBundle/Resources/config/doctrine/CategoryAffiliate.orm.yml


### Or Générer une entité 
    ```
    php app/console doctrine:generate:entity
    ```
    
      The Entity shortcut name:_    SelmiJobBundle:Job    
      
   
### Maintenant Doctrine peut générer les classes qui définissent nos objets pour nous avec la commande:
```
php app/console doctrine:generate:entities SelmiJobBundle
```

### Définissez les valeurs created_at et updated_at comme ci-dessous:
```
// src/Selmi/JobBundle/Entity/Job.php
public function setCreatedAtValue()
{
  if(!$this->getCreatedAt())
  {
    $this->created_at = new \DateTime();
  }
}
// ...
public function setUpdatedAtValue()
{
  $this->updated_at = new \DateTime();
}
```

```
// src/Selmi/JobBundle/Entity/Affiliate.php
public function setCreatedAtValue()
{
  $this->created_at = new \DateTime();
}
```


### Générer les tables à l'intérieur de cette base de données.
```
php app/console doctrine:schema:update --dump-sql
```


### Nous allons également demander à Doctrine de créer nos tables de BDD (ou les mettre à jour afin de prendre en compte notre configuration) avec la commande:
```
php app/console doctrine:schema:update --force
```

## 5- Les données initiales (Fixtures)
```
php composer.phar require --dev doctrine/doctrine-fixtures-bundle
```

### Enregistrez le bundle dans le Kernel app/AppKernel.php

```
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        // ...
        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            // ...
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }
 }

```

### Mettre à jour les dépendances 
```
 php composer.phar update
```

### Créer un dossier DataFixtures
 ### src/Selmi/JobBundle/DataFixtures/ORM/LoadJobData.php
 ### src/Selmi/JobBundle/DataFixtures/ORM/LoadCategoryData.php
 
### Une fois vos fixtures écrites, vous pouvez les charger via la ligne de commande suivante:
```
php app/console doctrine:fixtures:load
```

## 6- CRUD (Create - Read - Update - Delete)
### Maintenant, nous allons utiliser un peu de magie! Exécutez à l'invite de commande:
```
php app/console doctrine:generate:crud --entity=SelmiJobBundle:Job --route-prefix=selmi_job --with-write --format=yml
```

### Cela va créer un nouveau contrôleur src/Selmi/JobBundle/Controllers/JobController.php
### Nous aurons aussi besoin d'ajouter une méthode __toString() à notre classe Category pour être utilisée par le menu déroulant Catégorie du formulaire de modification d'offre:
  
### Videz le cache:
```
php app/console cache:clear --env=prod
php app/console cache:clear --env=dev
```

### Configuration des routes
```
php app/console debug:router
```

http://job.dev/job/
http://job.dev/app_dev.php/job/



