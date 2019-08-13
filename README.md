# LightFile
Small and practice file manager and drag and drop uploader

## Based on
* [alexantr](https://github.com/alexantr/filemanager/) - PHP File Manager

#How to use

```
	/* first param open te file manager, second param are method to use the url of file selected
        example:
        bg    -> put as background image the url of file selected
        val   -> change value of input
        event -> fire a custom event and pass the url as argument
    */
    $('#media').lightfile('http://localhost:8888/LightFile/file-functions.php','open', {'bg':'.post','val':'#post','event':'media_selected'});
    //example of return the url as argument
    $( document ).on( "media_selected", function( event, arg ) {
          console.log( arg );
    });
```

## Screenshots
![alt text](https://github.com/antxd/LightFile/blob/master/demo/demo0.png?raw=true)
![alt text](https://github.com/antxd/LightFile/blob/master/demo/demo1.png?raw=true)
![alt text](https://github.com/antxd/LightFile/blob/master/demo/demo2.png?raw=true)
![alt text](https://github.com/antxd/LightFile/blob/master/demo/demo3.png?raw=true)


