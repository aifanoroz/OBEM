package com.medical.obem;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.NumberPicker;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;


import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;

import cn.pedant.SweetAlert.SweetAlertDialog;
import es.dmoral.toasty.Toasty;

public class HealthProfile extends AppCompatActivity {
private Button male,female,submit;
NumberPicker noPicker = null;
boolean clickedmale,clickedfemale;
EditText Weight,Height,Tweight,bsugar,Systolic,Dystolic;
int age;
String gender,Calorie;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_health_profile);
        male=findViewById(R.id.maleBtn);
        female=findViewById(R.id.femaleBtn);
        submit=findViewById(R.id.submit);
        noPicker = findViewById(R.id.numberPicker);
        Weight=findViewById(R.id.weight);
        Height=findViewById(R.id.height);
        Tweight=findViewById(R.id.tweight);
        bsugar=findViewById(R.id.sugar);
        Systolic=findViewById(R.id.systolic);
        Dystolic=findViewById(R.id.dystolic);
        FirebaseAuth mAuth = FirebaseAuth.getInstance();
       final FirebaseUser user = mAuth.getCurrentUser();


        male.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                male.setActivated(true);
                female.setActivated(false);
                clickedmale=true;
                clickedfemale=false;


            }
        });

        female.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                female.setActivated(true);
                male.setActivated(false);
                clickedfemale=true;
                clickedmale=false;

            }
        });

        noPicker.setMaxValue(90);
        noPicker.setMinValue(10);
        //selector wheel wraps when reaching the min/max value.
        noPicker.setWrapSelectorWheel(false);
        // special format --> noPicker.setFormatter();
        noPicker.setValue(30);
        noPicker.setSaveEnabled(false);
        noPicker.setOnValueChangedListener(new NumberPicker.OnValueChangeListener() {
            @Override
            public void onValueChange(NumberPicker numberPicker, int oldValue, int newValue) {
                age = newValue;
            }
        });

        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

               if (age == 0){
                    Toast.makeText(getApplicationContext(), "Please Enter your AGE!", Toast.LENGTH_SHORT).show();
                }else  if (Weight.getText().toString().matches("")) {
                    Toast.makeText(getApplicationContext(),  "Please Enter your WEIGHT in kg!", Toast.LENGTH_SHORT).show();
                }else if (Tweight.getText().toString().matches("")){
                   Toast.makeText(getApplicationContext(),  "Please Enter cholesterol!", Toast.LENGTH_SHORT).show();
               }else if (bsugar.getText().toString().matches("")){
                    Toast.makeText(getApplicationContext(),  "Please Enter blood sugar!", Toast.LENGTH_SHORT).show();
                }else if(Integer.parseInt(Height.getText().toString()) < 60 || Integer.parseInt(Height.getText().toString()) > 220){
                    Toast.makeText(getApplicationContext(),  "Please Enter valid Height in cm!", Toast.LENGTH_SHORT).show();
                }else if (Dystolic.getText().toString().matches("")){
                   Toast.makeText(getApplicationContext(),  "Please Enter Dystolic!", Toast.LENGTH_SHORT).show();
               }
               else if (Systolic.getText().toString().matches("")){
                   Toast.makeText(getApplicationContext(),  "Please Enter Systolic!", Toast.LENGTH_SHORT).show();
               }
                else
               {
                   storeUserInfo(user);

               }


                }
        });


    }

    private void storeUserInfo(final FirebaseUser user) {
        if (clickedfemale==true){
            gender="female";
        }
        else if (clickedmale==true){
            gender="male";
        }
        else
        {
            Toasty.error(getApplicationContext(),"Please",Toasty.LENGTH_SHORT).show();
        }

       // final String date = today.getYear()+1900 + "-" + (1+today.getMonth()) + "-" + today.getDate();
        SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd");
        String date = df.format(new Date());

        float heightValue = Float.parseFloat(Height.getText().toString()) / 100;
        float weightValue = Float.parseFloat(Weight.getText().toString());
        float bmi = weightValue / (heightValue * heightValue);
        final String BMI=(String.format("%.1f",bmi));
        double BMRMale=88.362 + (13.397*(weightValue)) + (4.799*Double.parseDouble(Height.getText().toString())) - (5.677*(age));
        double BMRFemale=447.593 + (9.247*(weightValue)) + (3.098 *Double.parseDouble(Height.getText().toString())) - (4.330*(age));
        if (gender.equals("")){
            Log.e("t","asda");
        }
        else if (gender.equals("male")){
            Calorie=(String.format("%.0f",BMRMale*1.2));
        }
        else {
            Calorie=(String.format("%.0f",BMRFemale*1.2));
        }




        HashMap<String, Object> UserHealth = new HashMap<>();
        UserHealth.put("gender",gender );
        UserHealth.put("age", age);
        UserHealth.put("weight", Weight.getText().toString());
        UserHealth.put("sweight", Weight.getText().toString());
        UserHealth.put("height", Height.getText().toString());
        UserHealth.put("tweight",Tweight.getText().toString());
        UserHealth.put("systolic",Systolic.getText().toString());
        UserHealth.put("diastolic",Dystolic.getText().toString());
        UserHealth.put("bsugar",bsugar.getText().toString());
        UserHealth.put("date",date);
        UserHealth.put("calorie",Calorie);
        UserHealth.put("BMI",BMI);
        UserHealth.put("name",user.getDisplayName());
        UserHealth.put("uid",user.getUid());




        DatabaseReference mDatabase = FirebaseDatabase.getInstance().getReference("Health Status").child("Patient").child(user.getUid());
        DatabaseReference mDatabase2 = FirebaseDatabase.getInstance().getReference("Health Status History").child("Patient").child(user.getUid()).child(date);
        mDatabase.setValue(UserHealth).addOnCompleteListener(new OnCompleteListener<Void>() {
            @Override
            public void onComplete(@NonNull Task<Void> task) {
                int notificationId = 1;
                // Intent
                Intent intent = new Intent(HealthProfile.this, NotificationReciever.class);
                intent.putExtra("notificationId", notificationId);


                // PendingIntent
                PendingIntent pendingIntent = PendingIntent.getBroadcast(
                        HealthProfile.this, 0, intent, PendingIntent.FLAG_CANCEL_CURRENT
                );
                AlarmManager alarmManager = (AlarmManager)getSystemService(ALARM_SERVICE);
                Calendar calendar = Calendar.getInstance();
                calendar.set(Calendar.DAY_OF_WEEK,1);
                calendar.set(Calendar.HOUR_OF_DAY, 9);
                calendar.set(Calendar.MINUTE, 40);
                long alarmStartTime = calendar.getTimeInMillis();
                Log.e("lol","lol");
                alarmManager.setRepeating(AlarmManager.RTC_WAKEUP,alarmStartTime,AlarmManager.INTERVAL_DAY*7 ,pendingIntent);
                startActivity(new Intent(getApplicationContext(), HomeActivity.class));
                Toasty.success(getApplicationContext(),"Welcome", Toasty.LENGTH_SHORT).show();
                finish();
            }
        });

        mDatabase2.setValue(UserHealth).addOnCompleteListener(new OnCompleteListener<Void>() {
            @Override
            public void onComplete(@NonNull Task<Void> task) {
              Log.e("history","created");
            }
        });


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