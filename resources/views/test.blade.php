@extends('adminlte::page')


@section('content_header')
 	 <script src="https://www.gstatic.com/firebasejs/6.2.0/firebase-app.js"></script>
 	 <script src="https://www.gstatic.com/firebasejs/6.2.0/firebase-messaging.js"></script>


@stop


@section('content')




<h1>{{$_GET['nama']}} - {{$_GET['tahun']}}</h1>
<small>{{route('get_sipd',['tahun'=>$_GET['tahun'],'kodepemda'=>$_GET['id_next']])}}</small>




	<script>

		setTimeout(function(){
			window.location.href='{{route('get_sipd',['tahun'=>$_GET['tahun'],'kodepemda'=>$_GET['id_next']])}}';
		},1500);


	// 	function showToken(dt,ok){

	// 		console.log(dt);
	// 		console.log(ok);

	// 	}


	// 	function sendTokenToServer(currentToken){
	// 		console.log(currentToken);
	// 	}

	// 	function setTokenSentToServer(currentToken){
	// 		console.log(currentToken);

	// 	}

	//   // Your web app's Firebase configuration
	//   var firebaseConfig = {
	//     apiKey: "AIzaSyDeIvPANTXWSiBamwPgLhEbnWxdWEcEGBY",
	//     authDomain: "dssnotify-907bb.firebaseapp.com",
	//     // databaseURL: "https://dssnotify-907bb.firebaseio.com",
	//     // projectId: "dssnotify-907bb",
	//     // storageBucket: "dssnotify-907bb.appspot.com",
	//     messagingSenderId: "293950227608",
	//     appId: "1:293950227608:web:eba41c903b7a7d2fd47ced",
	//     measurementId: "G-94G26RZM6X"
	//   };
	//   // Initialize Firebase
	//   firebase.initializeApp(firebaseConfig);
	//   const messaging = firebase.messaging();
	//   messaging.usePublicVapidKey("BM1jA-f3IdkI3HZy3-TA9RdxgKdLv6Mb8KHwzYLnlH1tW4aXxnuyzjg9sawlR_YEbVOt6QIeU2URwsunnfIqnuo");

	//   navigator.serviceWorker.register('{{url('firebase-messaging-sw.js')}}')
	// 	.then((registration) => {
	// 	  messaging.useServiceWorker(registration);

	// 	  // Request permission and get token.....
	// 	});

	//   Notification.requestPermission().then((permission) => {
	// 	  if (permission === 'granted') {
	// 	    console.log('Notification permission granted.');
	// 	    // TODO(developer): Retrieve an Instance ID token for use with FCM.
	// 	    // ...
	// 	  } else {
	// 	    console.log('Unable to get permission to notify.');
	// 	  }
	// 	});


	//   messaging.getToken().then((currentToken) => {
	// 	  if (currentToken) {
	// 	    sendTokenToServer(currentToken);
	// 	    // updateUIForPushEnabled(currentToken);
	// 	  } else {
	// 	    // Show permission request.
	// 	    console.log('No Instance ID token available. Request permission to generate one.');
	// 	    // Show permission UI.
	// 	    // updateUIForPushPermissionRequired();
	// 	    setTokenSentToServer(false);
	// 	  }
	// 	}).catch((err) => {
	// 	  console.log('An error occurred while retrieving token. ', err);
	// 	  showToken('Error retrieving Instance ID token. ', err);
	// 	  setTokenSentToServer(false);
	// });

	// messaging.onTokenRefresh(() => {
	//   messaging.getToken().then((refreshedToken) => {
	//     console.log('Token refreshed.');
	//     // Indicate that the new Instance ID token has not yet been sent to the
	//     // app server.
	//     setTokenSentToServer(false);
	//     // Send Instance ID token to app server.
	//     sendTokenToServer(refreshedToken);
	//     // ...
	//   }).catch((err) => {
	//     console.log('Unable to retrieve refreshed token ', err);
	//     showToken('Unable to retrieve refreshed token ', err);
	//   });
	// });

	// messaging.onMessage((payload) => {
	//   console.log('Message received. ', payload);
	//   // ...
	// });
	

</script>
@stop