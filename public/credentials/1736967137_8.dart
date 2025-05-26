import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:smiu/SplashScreen.dart';
import 'package:smiu/student_screens/student_dashboard.dart';
import 'package:smiu/student_screens/supervisor_selection.dart';
import 'package:smiu/supervisorScreens/StudentRequestScreen.dart';
import 'package:smiu/supervisorScreens/supervisor_dashboard.dart';
import 'global/custom_snackbar.dart';

void main() async{
  await GetStorage.init();
runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      scaffoldMessengerKey: snackbarKey,
      debugShowCheckedModeBanner: false,
      home: SplashScreen(),
    );



  }
}


