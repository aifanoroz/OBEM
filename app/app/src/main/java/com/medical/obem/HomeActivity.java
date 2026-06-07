package com.medical.obem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.medical.obem.model.UserHealth;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;


import java.util.Calendar;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class HomeActivity extends AppCompatActivity {
    private TextView Calorie,Cholesterol,CurrentWeight,StartWeight,BloodPressure,BloodSugar,Name,Greeting,BMI,BMIstat,BloodSugarStat,BloodPressureStat;
    private ImageView setting;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);
        Calorie=findViewById(R.id.calorie);
        CurrentWeight=findViewById(R.id.cweight);
        StartWeight=findViewById(R.id.sweight);
        BloodPressure=findViewById(R.id.bp);
        Cholesterol=findViewById(R.id.calorieV);
        BloodSugar=findViewById(R.id.sugar);
        Name=findViewById(R.id.name);
        BMI=findViewById(R.id.bmi);
        Greeting=findViewById(R.id.welcome);
        setting=findViewById(R.id.logout);
        BottomNavigationView navView = findViewById(R.id.bottom_nav);
        BMIstat=findViewById(R.id.bmiV);
        BloodSugarStat=findViewById(R.id.sugarV);
        BloodPressureStat=findViewById(R.id.bpV);

        FirebaseUser user=FirebaseAuth.getInstance().getCurrentUser();
        if (user !=null){
            String uid =user.getUid();
            String name=user.getDisplayName();
            Name.setText(name);
            getuserInfo(uid);

        }
        else
        {
            startActivity(new Intent(HomeActivity.this, MainActivity.class));
        }


        setting.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {


               startActivity(new Intent(HomeActivity.this, SettingActivity.class));


            }
        });

        navView.setSelectedItemId(R.id.home);

            navView.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
                @Override
                public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                   switch (item.getItemId()) {
                       case R.id.home:
                           return true;
                       case R.id.diary:
                           startActivity(new Intent(getApplicationContext(), DailyDiary.class));
                           overridePendingTransition(0, 0);
                           finish();
                           return true;
                       case R.id.appoint:
                           startActivity(new Intent(getApplicationContext(), AppointmentHome.class));
                           overridePendingTransition(0, 0);
                           finish();
                           return true;
                       case R.id.review:
                           startActivity(new Intent(getApplicationContext(), DoctorReview.class));
                           overridePendingTransition(0, 0);
                           finish();
                           return true;
                   }
                       return false;

                }
            });





        Calendar c = Calendar.getInstance();
        int timeOfDay = c.get(Calendar.HOUR_OF_DAY);

        if(timeOfDay >= 0 && timeOfDay < 12){
            Greeting.setText("Good Morning");
        }else if(timeOfDay >= 12 && timeOfDay < 16){
            Greeting.setText("Good Afternoon");
        }else if(timeOfDay >= 16 && timeOfDay < 21){
            Greeting.setText("Good Evening");
        }else if(timeOfDay >= 21 && timeOfDay < 24){
            Greeting.setText("Good Evening");
        }



    }


    private void getuserInfo(String uid) {


        DatabaseReference PatientInfo = FirebaseDatabase.getInstance().getReference("Health Status").child("Patient").child(uid);
        PatientInfo.keepSynced(true);
        PatientInfo.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot)
            {

                if (dataSnapshot.exists())
                {
                    final UserHealth info =dataSnapshot.getValue(UserHealth.class);



                    float Bsugar=Float.parseFloat(info.getBsugar());
                    float Systolic=Float.parseFloat(info.getSystolic());
                    float Diastolic=Float.parseFloat(info.getDiastolic());
                    float bmi =Float.parseFloat(info.getBMI());
                    float Cholestrol=Float.parseFloat(info.getTweight());

                    BMI.setText(String.valueOf(bmi));
                    CurrentWeight.setText(info.getWeight()+" KG");
                    BloodPressure.setText(info.getSystolic()+"/"+info.getDiastolic());
                    BloodSugar.setText(info.getBsugar());
                    Calorie.setText(info.getTweight());
                    StartWeight.setText(info.getSweight()+" KG");

                    CholestrolLevel(Cholestrol);
                    BloodSugarLevel(Bsugar);
                    BMILevel(bmi);
                    BloodPressureLevel(Systolic,Diastolic);


                }

            }

            @Override
            public void onCancelled(DatabaseError databaseError) {

            }
        });

    }

    private void CholestrolLevel(float cholestrol) {
        if (cholestrol < 5.2){
            Cholesterol.setText("Low risk");
            Cholesterol.setTextColor(Color.parseColor("#23C552"));
        }else if ((cholestrol <= 2) && (cholestrol <= 6.2)){
            Cholesterol.setText("Medium Risk");
            Cholesterol.setTextColor(Color.parseColor("#ffcc00"));
        }else if(cholestrol > 6.2) {
            Cholesterol.setText("High Risk");
            Cholesterol.setTextColor(Color.parseColor("#ff1616"));
        }
        else
        {
            Log.e("error","invalid cholesterol value");
        }
    }

    private void BloodPressureLevel(float systolic, float diastolic) {
        if (systolic<120 && diastolic<80){
            BloodPressureStat.setText("Normal");
            BloodPressureStat.setTextColor(Color.parseColor("#23C552"));
        }
        else if(systolic>=120 && systolic<=129 && diastolic<80){
            BloodPressureStat.setText("Elevated");
            BloodPressureStat.setTextColor(Color.parseColor("#ffcc00"));
        }
        else if(systolic>=130 && systolic<=139 || diastolic>=80 && diastolic<=89){
            BloodPressureStat.setText("Mild Hypertension");
            BloodPressureStat.setTextColor(Color.parseColor("#ff6700"));
        }
        else if(systolic>=140 || diastolic>=90){
            BloodPressureStat.setText("Hypertension");
            BloodPressureStat.setTextColor(Color.parseColor("#ff1616"));
        }
        else
        {
            Log.e("error","invalid value");
        }

    }

    private void BMILevel(float bmi) {
        if (bmi >= 30){
            BMIstat.setText("Obese");
            BMIstat.setTextColor(Color.parseColor("#ff1616"));
        }else if ((bmi >= 25) && (bmi < 30)){
            BMIstat.setText("Overweight");
            BMIstat.setTextColor(Color.parseColor("#ffcc00"));
        }else if (bmi <= 18){
            BMIstat.setText("Under Weight");
            BMIstat.setTextColor(Color.parseColor("#ff1616"));
        }else if((bmi > 18) && (bmi < 25) ){
            BMIstat.setText("Normal");
            BMIstat.setTextColor(Color.parseColor("#23C552"));
        }

    }

    private void BloodSugarLevel(float bsugar) {
        if (bsugar>=1 && bsugar<=4){
            BloodSugarStat.setText("Hypoglycemia");
            BloodSugarStat.setTextColor(Color.parseColor("#ff1616"));
        }
        else if (bsugar>=4 && bsugar<=6){
            BloodSugarStat.setText("Normal");
            BloodSugarStat.setTextColor(Color.parseColor("#23C552"));
        }
        else if (bsugar>=6 && bsugar<=33){
            BloodSugarStat.setText("Hyperglycemia");
            BloodSugarStat.setTextColor(Color.parseColor("#ff1616"));
        }
        else {
            Log.e("error","invalid value");
        }
    }

    public void onBackPressed() {
        //super.onBackPressed();
        SweetAlertDialog progressDialog = new SweetAlertDialog(this, SweetAlertDialog.WARNING_TYPE);
        progressDialog.setCancelable(false);
        progressDialog.setTitleText("Are you sure you want to exit?");
        progressDialog.setCancelText("No");
        progressDialog.setConfirmText("Yes");
        progressDialog.setCanceledOnTouchOutside(true);
        progressDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
            @Override
            public void onClick(SweetAlertDialog sweetAlertDialog) {
                sweetAlertDialog.dismiss();
                finishAffinity();
                finish();
            }
        });
        progressDialog.show();
    }
}