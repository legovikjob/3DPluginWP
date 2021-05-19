<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
$ID = get_the_ID();
$filearray = get_post_meta( get_the_ID(), 'wp_custom_attachment', true );
$this_file = $filearray['url'];
$str=strrpos($this_file, "/" , -1);
$row=substr($this_file, $str+1, strlen ($this_file));
//echo $this_file;
//echo 'haahahaha';
echo $this_file;
echo $row;
echo "ttttttt";
$row2=substr($this_file,0,strlen ($this_file)-4);
$row3=$row2.'.usdz';
//echo $this_file;
echo $row3;
?>
    <body>
    <section id="business-plan2">
        <div class="container">

            <div class="row">

                <!-- Start Col -->
                <div class="col-lg-6 col-md-12 col-obj">
                    <div class="corner-box-1">
                    <model-viewer class="modern-object corner-textbox-1" style="

" src="<?echo $this_file;?>" alt="A 3D model of an astronaut" auto-rotate camera-controls data-js-focus-visible ios-src="<?=$row3;?>" ar ar-modes="webxr scene-viewer quick-look" ar-scale="auto" camera-controls></model-viewer>
                    <div class="business-item-img" style="display: none">
                        <?php echo '<div id="projector-'.$ID.'">' ?>
                    </div>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <!-- Start Col -->
            <div class="col-lg-6 col-md-12 pl-4">
                <div class="business-item-info">
                    <?php  echo '<h3>'.get_the_title($ID).'</h3>'?>

                    <p> <?php $my_post_obj = get_post( $ID ); // параметр функции - ID поста, содержимое которого нужно вывести
                        echo $my_post_obj->post_content;
                        ?></p>

                    <a class="btn btn-common fancy-class" id="watch">View in AR</a>
                </div>
            </div>
            <!-- End Col -->
        </div>
        </div>

    </section>
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <script nomodule src="https://unpkg.com/@google/model-viewer/dist/model-viewer-legacy.js"></script>
    <script type="module">

        import * as THREE from './wp-content/themes/twentytwenty/assets/js/three.module.js';
        import {TrackballControls} from 'https://threejsfundamentals.org/threejs/resources/threejs/r115/examples/jsm/controls/TrackballControls.js';
        import { OrbitControls } from './wp-content/themes/twentytwenty/assets/js/OrbitControls.js';
        import { GLTFLoader } from './wp-content/themes/twentytwenty/assets/js/GLTFLoader.js';
        import { RGBELoader } from './wp-content/themes/twentytwenty/assets/js/RGBELoader.js';
        import { RoughnessMipmapper } from './wp-content/themes/twentytwenty/assets/js/RoughnessMipmapper.js';

        var  container2, controls2;
        var  camera2, scene2, renderer2;
        var objW, objP, objMat, objChair;
        var textureBlueAt ,textureBlueSe, textureGreenAt,textureGreenSe, textureOriginalAt, textureOriginalASe;
        var door, materialDoorOriginal, materialDoorGray, materialDoorYellow;
        var url='<?php echo $this_file;?>';
        var objName='<?php echo $row;?>';

        init2();

        render2();

        setTimeout(function(){
            // animF();
        }, 5000);


        $("body").keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
        });
        $("body").keydown(function(e) {
            if (e.which == 88) {
                camera2.position.x += 0.1;
                console.log('x = '+camera2.position.x);
                render2();
                // controls2.target.x +=0.1;
                // console.log('x = '+ controls2.target.x);
                // controls2.update();
            }
            if (e.which == 90) {
                camera2.position.x -= 0.1;
                console.log('x = '+camera2.position.x);
                render2();
                // controls2.target.x -=0.1;
                // console.log('x = '+ controls2.target.x);
                // controls2.update();
            }
            if (e.which == 67) {
                camera2.position.y += 0.1;
                console.log('y = '+ camera2.position.y);
                render2();
                // controls2.target.y +=0.1;
                // console.log('y = '+ controls2.target.y);
                // controls2.update();
            }
            if (e.which == 86) {
                camera2.position.y -= 0.1;
                console.log('y = '+camera2.position.y);
                render2();
                // controls2.target.y -=0.1;
                // console.log('y = '+ controls2.target.y);
                // controls2.update();
            }
            if (e.which == 66) {
                camera2.position.z += 0.1;
                console.log('z = '+ camera2.position.z);
                render2();
                // controls2.target.z +=0.1;
                // console.log('z = '+ controls2.target.z);
                // controls2.update();
            }
            if (e.which == 78) {
                camera2.position.z -= 0.1;
                console.log('z = '+camera2.position.z);
                render2();
                // controls2.target.z -=0.1;
                // console.log('z = '+ controls2.target.z);
                // controls2.update();
            }
            if (e.which == 77) {

                console.log(' = '+camera2.position.x+' '+camera2.position.y+' '+camera2.position.z);

            }
            if (e.which == 65) {

                console.log(camera2);

            }
        });

        function init2() {

            container2 = document.createElement( 'div' );
            container2.className = "dViewer";
            document.getElementById("projector-<?php echo $ID;?>").appendChild( container2 );

//window.innerWidth / window.innerHeight
            camera2 = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 0.1, 100 );

            //camera2.position.set( -0.6, 3.5, 4.3 );
            console.log(camera2.position.x +' '+camera2.position.y+' '+camera2.position.z);
            scene2 = new THREE.Scene();
            console.log(camera2);
            new RGBELoader()
                .setDataType( THREE.UnsignedByteType )
                .setPath( '/wp-content/themes/twentytwenty/assets/images/' )
                .load( 'royal_esplanade_1k.hdr', function ( texture ) {

                    var envMap = pmremGenerator.fromEquirectangular( texture ).texture;

                    scene2.background = new THREE.Color('#ffffff00');
                    scene2.environment = envMap;

                    texture.dispose();
                    pmremGenerator.dispose();

                    render2();
                    var manager = new THREE.LoadingManager();
                    //  manager.setCrossOrigin(true);
                    manager.onStart = function ( url, itemsLoaded, itemsTotal ) {

                        console.log( 'Started loading file: ' + url + '.\nLoaded ' + itemsLoaded + ' of ' + itemsTotal + ' files.' );

                    };

                    manager.onLoad = function ( ) {

                        console.log( 'Loading complete!');

                    };


                    manager.onProgress = function ( url, itemsLoaded, itemsTotal ) {

                        console.log( 'Loading file: ' + url + '.\nLoaded ' + itemsLoaded + ' of ' + itemsTotal + ' files.' );

                    };
                    console.log(manager.itemError('<?php echo $this_file;?>'));
                    manager.onError = function ( url ) {

                        console.log( 'There was an error loading ' + url );

                    };

                    console.log( manager.resolveURL('<?php echo $this_file;?>'));
                    // use of RoughnessMipmapper is optional
                    var roughnessMipmapper = new RoughnessMipmapper( renderer2 );

                    var loader = new GLTFLoader(manager ).setPath( '/wp-content/uploads/2020/07/' );
                    // loader.setCrossOrigin;
                    // loader.setRequestHeader( { 'X-Hello': 'World' } );
                    // loader.setCrossOrigin(loader.options.crossOrigin);
                    loader.load( objName, function ( gltf ) {

                        gltf.scene.traverse( function ( child ) {

                            if ( child.isMesh ) {

                                roughnessMipmapper.generateMipmaps( child.material );

                            }

                        } );
                        objW = gltf.scene;
                        console.log(gltf.scene);
                        console.log(objW.position.x + ','  + objW.position.y + ',' + objW.position.z);
                    //    objW.position.set( 0, 0, 0 );
                   //     console.log(objW.position.x + ','  + objW.position.y + ',' + objW.position.z);
                      //  console.log( gltf.scene.getScaleX());
                        scene2.add( gltf.scene );
                        // objectURLs.forEach( ( url ) => URL.revokeObjectURL( url ) );
                        roughnessMipmapper.dispose();

                        render2();


                    } );

                } );

            renderer2 = new THREE.WebGLRenderer( { antialias: true } );

            renderer2.setPixelRatio( window.devicePixelRatio );
            if(window.innerWidth<520){
                renderer2.setSize( window.innerWidth/1, window.innerHeight/1 );
            }
            renderer2.setSize( window.innerWidth/1.5, window.innerHeight/1.5 );
            renderer2.toneMapping = THREE.ACESFilmicToneMapping;
            renderer2.toneMappingExposure = 0.8;
            renderer2.outputEncoding = THREE.sRGBEncoding;
            container2.appendChild( renderer2.domElement );

            var pmremGenerator = new THREE.PMREMGenerator( renderer2 );
            pmremGenerator.compileEquirectangularShader();

          // camera2.updateProjectionMatrix();
            controls2 = new OrbitControls( camera2, renderer2.domElement );
            // camera2.position.x=-0.20000000000000004;
            // camera2.position.y=0.30000000000000004;
            // camera2.position.z=4.4;
            //controls2.update();
            controls2.addEventListener( 'change', render2 ); // use if there is no animation loop
          //  controls2.enableZoom = false;
           // controls2.minDistance = 3.5;
          //  controls2.maxDistance = 3.5;
        //    if(window.innerWidth<520){
        //        controls2.minDistance = 3.5;
        //        controls2.maxDistance = 3.5;
         //   }
            controls2.enablePan=false;
           controls2.target.set( 0, 0, 0 );
         //   controls2.update();

            window.addEventListener( 'resize', onWindowResize2, false );

        }

        function onWindowResize2() {

            camera2.aspect = window.innerWidth / window.innerHeight;
            camera2.updateProjectionMatrix();

            renderer2.setSize( window.innerWidth/1.5, window.innerHeight/1.5 );

            render2();

        }

        //
        function animF() {
            // console.log(objW);
            objW.rotation.y+=0.005;

            render2();
            requestAnimationFrame(animF);
        }
        function render2() {

            renderer2.render( scene2, camera2 );

        }

        function dOriginal(){

            door.traverse((o) => {
                if (o.isMesh){

                    if(o.name=="Box021"){
                        o.material=materialDoorOriginal;

                        o.material.needsUpdate = true;
                    }



                }
            });
            render3();
        }
        function dGray(){

            door.traverse((o) => {

                if (o.isMesh){
                    console.log(o);
                    if(o.name=="Box021"){
                        o.material=materialDoorGray;
                        o.material.needsUpdate = true;
                    }
                }
            });
            render3();
        }
        function dYellow(){

            door.traverse((o) => {
                console.log(o);
                if (o.isMesh){

                    if(o.name=="Box021"){
                        o.material=materialDoorYellow;
                        o.material.needsUpdate = true;
                    }


                }
            });
            render3();
        }
        function arDoor(id){
            $('.doorInAr').attr('id',id);
        }
        $('.Yellow-text').on('click', function() {
            dYellow();
            arDoor('Door3');

        });
        $('.Gray-text').on('click', function() {
            dGray();
            arDoor('Door2');

        });
        $('.Orig-text').on('click', function() {
            dOriginal();
            arDoor('Door');

        });
        $('.btn-text-d').on('click', function() {
            $(this).attr("class");
            console.log($(this).attr("class"));
            if(!$(this).hasClass("activeD")){
                $(".activeD").removeClass("activeD");
                $(this).addClass("activeD");
            }

        });

        function blue(){

            objChair.traverse((o) => {
                if (o.isMesh){

                    if(o.name=="Plane003"){
                        //   textureBlue.offset.x=0;
                        //   textureBlue.offset.y=-7;
                        o.material.map=textureBlueAt;

                        o.material.needsUpdate = true;
                    }
                    if(o.name=="Plane"){
                        //   textureBlue.offset.x=0;
                        //   textureBlue.offset.y=-11;
                        o.material.map=textureBlueSe;
                        o.material.needsUpdate = true;
                    }


                }
            });
            render4();
        }
        function green(){

            objChair.traverse((o) => {
                if (o.isMesh){

                    if(o.name=="Plane003"){
                        //  textureGreen.offset.x=0;
                        //  textureGreen.offset.y=-7;
                        o.material.map=textureGreenAt;
                        o.material.needsUpdate = true;
                    }
                    if(o.name=="Plane"){
                        // textureGreen.offset.x=0;
                        // textureGreen.offset.y=-11;

                        o.material.map=textureGreenSe;
                        o.material.needsUpdate = true;
                    }


                }
            });
            render4();
        }
        function original(){

            objChair.traverse((o) => {
                if (o.isMesh){

                    if(o.name=="Plane003"){
                        //   textureOriginal.offset.x=0;
                        //  textureOriginal.offset.y=-7;
                        //textureOriginal.repeat=8;
                        o.material.map=textureOriginalAt;
                        o.material.needsUpdate = true;
                    }
                    if(o.name=="Plane"){
                        // textureOriginal.offset.x=0;
                        // textureOriginal.offset.y=-11;
                        // textureOriginal.repeat=12;
                        o.material.map=textureOriginalASe;
                        o.material.needsUpdate = true;
                    }


                }
            });
            render4();
        }
        function arChar(id){
            $('.chairInAr').attr('id',id);
        }
        $('.blue-text').on('click', function() {
            blue();
            arChar('chair_blue');

        });
        $('.green-text').on('click', function() {
            green();
            arChar('chair_green');

        });
        $('.original-text').on('click', function() {
            original();
            arChar('chair');

        });
    </script>
    <script>
        $('.fancy-class').on('click', function() {
            $(this).attr('id');
            console.log($(this).attr('id'));
            console.log(getMobileOperatingSystem($(this).attr('id')));
        });
        function getMobileOperatingSystem(name) {
            name='divan';
            var userAgent = navigator.userAgent || navigator.vendor || window.opera;

            // Windows Phone must come first because its UA also contains "Android"
            if (/windows phone/i.test(userAgent)) {
                var gltf = new URL('http://ar1.angelsit.ru/wp-content/uploads/2020/06/'+name+'.glb');
                var link = encodeURIComponent(location.href+'#no-ar-fallback');
                var title = encodeURIComponent(document.title);

                //option to add resizable <true/false> in future
                intent = 'intent://arvr.google.com/scene-viewer/1.1';
                intent += '?file=' + gltf;
                intent += '&mode=ar_preferred';
                intent += '&link=' + link;
                intent += '&title=' + 'test';
                intent += '#Intent;scheme=https;package=com.google.ar.core;action=android.intent.action.VIEW;';
                intent += 'S.browser_fallback_url='+link+';end;';

                var anchor = document.createElement('a');
                anchor.setAttribute('href', intent);
                anchor.click();

                window.addEventListener('hashchange', function(){
                    $('.arButton').removeClass('show');
                    alert('Sorry, your device does not support AR');
                }, {once: true});
                // track('Scene Viewer:Start Augment:');
                console.log(intent);
                return "Android";
                // document.location.href = "https://24alpaca.ru/models/watch.glb";
                return "Windows Phone";
            }

            if (/android/i.test(userAgent)) {
                // document.location.href = "https://ch45083.tmweb.ru/models/watch.glb";
                var gltf = new URL('https://24alpaca.ru/models/'+name+'.glb');
                var link = encodeURIComponent(location.href+'#no-ar-fallback');
                var title = encodeURIComponent(document.title);

                //option to add resizable <true/false> in future
                intent = 'intent://arvr.google.com/scene-viewer/1.1';
                intent += '?file=' + gltf;
                intent += '&mode=ar_preferred';
                intent += '&link=' + link;
                intent += '&title=' + 'test';
                intent += '#Intent;scheme=https;package=com.google.ar.core;action=android.intent.action.VIEW;';
                intent += 'S.browser_fallback_url='+link+';end;';

                var anchor = document.createElement('a');
                anchor.setAttribute('href', intent);
                anchor.click();

                window.addEventListener('hashchange', function(){
                    $('.arButton').removeClass('show');
                    // alert('Sorry, your device does not support AR');
                }, {once: true});
                // track('Scene Viewer:Start Augment:');
                console.log(intent);
                return "Android";
            }

            // iOS detection from: http://stackoverflow.com/a/9039885/177710
            if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                document.location.href = "http://ar1.angelsit.ru/wp-content/uploads/2020/06/"+name+".usdz";
                return "iOS";
            }

            return "unknown";
        }
    </script>
    <?php
    //echo get_the_ID();
    ?>
    </body>

<?php
get_footer();
