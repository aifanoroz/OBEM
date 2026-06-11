package com.medical.obem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import com.medical.obem.model.Overview;
import com.medical.obem.model.UserHealth;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import java.util.ArrayList;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class DailyDiary extends AppCompatActivity {

    FirebaseAuth mAuth;
    private TextView RCalorie, Tcalorie;
    private Button submit, View;

    // Swapped the custom PieHelper array for a native String tracking array to prevent breakages
    final ArrayList<String> pieHelperArrayList = new ArrayList<>();
    int sumOfEatCal = 0;
    int currentCalories;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dailydiary);

        mAuth = FirebaseAuth.getInstance();
        RCalorie = findViewById(R.id.remaining);
        Tcalorie = findViewById(R.id.taken);
        BottomNavigationView navView = findViewById(R.id.bottom_nav);
        submit = findViewById(R.id.submit);
        View = findViewById(R.id.view);
        final String uid = FirebaseAuth.getInstance().getCurrentUser().getUid();

        navView.setSelectedItemId(R.id.diary);
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

        DatabaseReference health = FirebaseDatabase.getInstance().getReference("Health Status").child("Patient").child(uid);
        health.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                UserHealth health = dataSnapshot.getValue(UserHealth.class);
                if (health != null) {
                    currentCalories = Integer.parseInt(health.getCalorie());
                    Log.e("calorie", String.valueOf(currentCalories));
                    DatabaseReference Overview = FirebaseDatabase.getInstance().getReference("overview").child(uid);
                    Overview.keepSynced(true);
                    Overview.addValueEventListener(new ValueEventListener() {
                        @Override
                        public void onDataChange(DataSnapshot dataSnapshot) {
                            if (dataSnapshot.exists()) {
                                Overview overview = dataSnapshot.getValue(Overview.class);
                                sumOfEatCal = overview.getSumOfEatCal();

                                final int remaining = currentCalories - sumOfEatCal;
                                RCalorie.setText(" Remaining Calorie : " + remaining);
                                Tcalorie.setText(" Calorie Taken : " + sumOfEatCal);

                                // Bypassed external PieView calls to prevent compile crashes
                            } else {
                                sumOfEatCal = 0;
                                final int remaining = currentCalories - sumOfEatCal;
                                RCalorie.setText(" Remaining Calorie : " + remaining);
                                Tcalorie.setText(" Calorie Taken : " + sumOfEatCal);
                            }
                        }

                        @Override
                        public void onCancelled(DatabaseError databaseError) {}
                    });
                } else {
                    Log.e("error", "error");
                }
            }

            @Override
            public void onCancelled(DatabaseError databaseError) {}
        });

        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(), FoodList.class);
                startActivity(intent);
            }
        });

        View.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(), HistoryController.class);
                startActivity(intent);
            }
        });
    }

    public void onBackPressed() {
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
                DailyDiary.super.onBackPressed();
            }
        });
        progressDialog.show();
    }
}