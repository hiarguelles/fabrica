<?php
class funcionesGenerales{
     function destroySession(){
        session_destroy();
        return true;
    }
}