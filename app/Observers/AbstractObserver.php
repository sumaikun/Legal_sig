<?php

 namespace Sig\Observers; 
    
 
abstract class AbstractObserver { 
  
 
    abstract public function saved($model);
 
    abstract public function saving($model);
 
    abstract public function deleted($model);
 
    
}