package com.medical.obem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.medical.obem.model.Appointment;

import java.util.Calendar;
import java.util.HashMap;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class AppointmentHome extends AppCompatActivity {
    private Button history,submit;
    private DatabaseReference ref;
    private TextView title,time,date,Status,Greeting,Name;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_appointment_home);
        BottomNavigationView navView = findViewById(R.id.bottom_nav);
        history=findViewById(R.id.history);
        submit=findViewById(R.id.submit);
        title=findViewById(R.id.title);
        time=findViewById(R.id.time);
        date=findViewById(R.id.date);
        Name=findViewById(R.id.username);
        Status=findViewById(R.id.status);
        Greeting=findViewById(R.id.welcome);
        navView.setSelectedItemId(R.id.appoint);
        FirebaseUser user=FirebaseAuth.getInstance().getCurrentUser();
        if (user !=null){
            String name=user.getDisplayName();
            Name.setText(name);

        }
        else
        {
            startActivity(new Intent(AppointmentHome.this, MainActivity.class));
        }

        navView.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                switch (item.getItemId()) {
                    case R.id.home:
                        startActivity(new Intent(getApplicationContext(), HomeActivity.class));
                        overridePendingTransition(0, 0);
                        finish();
                        return true;
                    case R.id.diary:
                        startActivity(new Intent(getApplicationContext(), DailyDiary.class));
                        overridePendingTransition(0, 0);
                        finish();
                        return true;
                    case R.id.appoint:
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

        history.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(),AppointmentHistory.class);
                startActivity(intent);
            }
        });
        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(),AppointmentActivity.class);
                startActivity(intent);
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




        FirebaseDatabase database = FirebaseDatabase.getInstance();
        ref = database.getReference("Appointment").child(user.getUid());
        ref.keepSynced(true);
        ref.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                if (dataSnapshot.exists()) {
                    Appointment appoint = dataSnapshot.getValue(Appointment.class);
                    int status = appoint.getDoctorStatus();
                    title.setText(appoint.getDocname());
                    time.setText("Time: "+appoint.getTime());
                    date.setText("Date: "+appoint.getDate());
                    if (status == 1) {
                        new Handler(Looper.getMainLooper()).postDelayed(new Runnable() {
                            public void run() {
                                final SweetAlertDialog progressDialog = new SweetAlertDialog(AppointmentHome.this, SweetAlertDialog.WARNING_TYPE);
                                progressDialog.setTitleText(" You have an active appointment");
                                if (!isFinishing()) {
                                    progressDialog.show();
                                }

                        Status.setText("Status: "+"Active");
                            }
                        }, 300);

                    } else if(status == 2) {
                        Status.setText("Status: "+"Completed");
                    }
                    else
                    {
                        Status.setText("Status: "+"Cancelled");
                    }


                }
                else {
                    title.setText("No appointment scheduled");
                    new Handler(Looper.getMainLooper()).postDelayed(new Runnable() {
                        @Override
                        public void run() {
                            final SweetAlertDialog progressDialog = new SweetAlertDialog(AppointmentHome.this, SweetAlertDialog.WARNING_TYPE);
                            progressDialog.setCancelable(false);
                            progressDialog.setTitleText("You have no appointment. Do you want to book one?");
                            progressDialog.setCancelText("No");
                            progressDialog.setConfirmText("Yes");
                            progressDialog.setCanceledOnTouchOutside(true);

                            progressDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
                                @Override
                                public void onClick(SweetAlertDialog sweetAlertDialog) {
                                    sweetAlertDialog.dismiss();
                                    Intent intent = new Intent(getApplicationContext(), AppointmentActivity.class);
                                    startActivity(intent);

                                }
                            });
                            if (!isFinishing()) {
                                progressDialog.show();
                            }

                        }
                    }, 100);
                }

                }



            @Override
            public void onCancelled(DatabaseError databaseError) {
                if (databaseError != null) {

                }
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
                AppointmentHome.super.onBackPressed();
            }
        });
        progressDialog.show();
    }
}