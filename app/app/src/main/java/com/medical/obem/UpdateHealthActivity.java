package com.medical.obem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;


import com.medical.obem.model.UserHealth;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;


import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;

import cn.pedant.SweetAlert.SweetAlertDialog;
import es.dmoral.toasty.Toasty;

public class UpdateHealthActivity extends AppCompatActivity {
    EditText Weight,bsugar,Systolic,Dystolic,Cholesterol;
    private FirebaseAuth mAuth;
    private DatabaseReference mDatabase,mDatabase2;
    private Button submit;
    String Calorie;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_health);
        Weight=findViewById(R.id.weight);
        bsugar=findViewById(R.id.sugar);
        Systolic=findViewById(R.id.systolic);
        Dystolic=findViewById(R.id.dystolic);
        submit=findViewById(R.id.submit);
        Cholesterol=findViewById(R.id.cl);
        mAuth= FirebaseAuth.getInstance();
        final FirebaseUser user = mAuth.getCurrentUser();

        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (Weight.getText().toString().matches("")) {
                    Toast.makeText(getApplicationContext(),  "Please Enter your WEIGHT in kg", Toast.LENGTH_SHORT).show();
                }else if (bsugar.getText().toString().matches("")){
                    Toast.makeText(getApplicationContext(),  "Please Enter blood sugar", Toast.LENGTH_SHORT).show();
                }
                else if (Cholesterol.getText().toString().matches("")){
                    Toast.makeText(getApplicationContext(),  "Please Enter cholesterol value!", Toast.LENGTH_SHORT).show();
                }else if (Dystolic.getText().toString().matches("")){
                    Toast.makeText(getApplicationContext(),  "Please Enter Dystolic", Toast.LENGTH_SHORT).show();
                }
                else if (Systolic.getText().toString().matches("")){
                    Toast.makeText(getApplicationContext(),  "Please Enter Systolic", Toast.LENGTH_SHORT).show();
                }
                else
                {
                    updateUserInfo(user);




                }


            }
        });

    }


    private void updateUserInfo(final FirebaseUser user) {
        DatabaseReference PatientDetail = FirebaseDatabase.getInstance().getReference("Health Status").child("Patient").child(user.getUid());
        PatientDetail .keepSynced(true);
        PatientDetail .addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot)
            {

                if (dataSnapshot.exists())
                {
                    Log.e("what","waht");
                    final UserHealth info2 =dataSnapshot.getValue(UserHealth.class);
                    SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd");
                    final String date = df.format(new Date());
                    float heightValue = Float.parseFloat(info2.getHeight()) / 100;
                    float weightValue = Float.parseFloat(Weight.getText().toString());
                    String weight=String.valueOf(weightValue);
                    float bmi = weightValue / (heightValue * heightValue);
                    String BMI=(String.format("%.1f",bmi));
                    double BMRMale=88.362 + (13.397*(weightValue)) + (4.799*Double.parseDouble(info2.getHeight())) - (5.677*(info2.getAge()));
                    double BMRFemale=447.593 + (9.247*(weightValue)) + (3.098 *Double.parseDouble(info2.getHeight()) - (4.330*(info2.getAge())));
                    if (info2.getGender().equals("")){
                        Log.e("t","asda");
                    }
                    else if (info2.getGender().equals("male")){
                        Calorie=(String.format("%.0f",BMRMale*1.2));
                    }
                    else {
                        Calorie=(String.format("%.0f",BMRFemale*1.2));
                    }

                    final HashMap<String, Object> UserHealth = new HashMap<>();
                    UserHealth.put("systolic",Systolic.getText().toString());
                    UserHealth.put("diastolic",Dystolic.getText().toString());
                    UserHealth.put("bsugar",bsugar.getText().toString());
                    UserHealth.put("weight", weight);
                    UserHealth.put("date",date);
                    UserHealth.put("tweight",Cholesterol.getText().toString());
                    UserHealth.put("calorie",Calorie);
                    UserHealth.put("BMI",BMI);


                    mDatabase= FirebaseDatabase.getInstance().getReference().child("Health Status").child("Patient").child(user.getUid());
                    mDatabase.updateChildren(UserHealth)
                            .addOnCompleteListener(new OnCompleteListener<Void>() {
                                @Override
                                public void onComplete(@NonNull Task<Void> task)
                                {
                                    if (task.isSuccessful())
                                    {
                                        Log.e("what","problem");
                                        mDatabase2= FirebaseDatabase.getInstance().getReference("Health Status History").child("Patient").child(user.getUid()).child(date);
                                        mDatabase2.setValue(UserHealth).addOnCompleteListener(new OnCompleteListener<Void>() {
                                            @Override
                                            public void onComplete(@NonNull Task<Void> task) {
                                                int notificationId = 1;
                                                // Intent
                                                Intent intent = new Intent(UpdateHealthActivity.this, NotificationReciever.class);
                                                intent.putExtra("notificationId", notificationId);


                                                // PendingIntent
                                                PendingIntent pendingIntent = PendingIntent.getBroadcast(
                                                        UpdateHealthActivity.this, 0, intent, PendingIntent.FLAG_CANCEL_CURRENT
                                                );
                                                AlarmManager alarmManager = (AlarmManager)getSystemService(ALARM_SERVICE);
                                                Calendar calendar = Calendar.getInstance();
                                                calendar.set(Calendar.DAY_OF_WEEK,1);
                                                calendar.set(Calendar.HOUR_OF_DAY, 9);
                                                calendar.set(Calendar.MINUTE, 40);
                                                long alarmStartTime = calendar.getTimeInMillis();
                                                alarmManager.setRepeating(AlarmManager.RTC_WAKEUP,alarmStartTime,AlarmManager.INTERVAL_DAY*7 ,pendingIntent);
                                                startActivity(new Intent(getApplicationContext(), HomeActivity.class));
                                                Toasty.normal(UpdateHealthActivity.this, "Updated", Toast.LENGTH_SHORT).show();
                                                finish();

                                            }
                                        });


                                    }
                                    else
                                    {

                                        String message = task.getException().toString();
                                        Toast.makeText(UpdateHealthActivity.this, "Error: " + message, Toast.LENGTH_SHORT).show();
                                    }
                                }
                            });



                }

            }

            @Override
            public void onCancelled(DatabaseError databaseError) {
                Log.e("Error",databaseError.getMessage());

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
                UpdateHealthActivity.super.onBackPressed();
            }
        });
        progressDialog.show();
    }


}