package com.medical.obem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;

import com.medical.obem.model.DocReview;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.medical.obem.model.Doctor;

import java.util.ArrayList;
import java.util.Date;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class DoctorReview extends AppCompatActivity {
    ListView reviewListView;
    ArrayAdapter<DocReview> adapter;
    ArrayList<DocReview> reviewArrayList;
    private DatabaseReference review,review2;
    private TextView BloodPressure,BloodSugar,Weight,Comment;
    Date today = new Date();
    FirebaseDatabase database = FirebaseDatabase.getInstance();
    TextView textView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_doctor_review2);
        String date = today.getYear()+1900 + "-" + (1+today.getMonth()) + "-" + today.getDate();
        reviewArrayList = new ArrayList<>();
        BottomNavigationView navView = findViewById(R.id.bottom_nav);
       // reviewListView = findViewById(R.id.historyListView);
        FirebaseUser user= FirebaseAuth.getInstance().getCurrentUser();
        final String uid = user.getUid();
        review= FirebaseDatabase.getInstance().getReference("DoctorReview").child(uid);

        BloodPressure=findViewById(R.id.bpressure);
        BloodSugar=findViewById(R.id.bsugar);
        Weight=findViewById(R.id.weight);
        Comment=findViewById(R.id.comment);


        navView.setSelectedItemId(R.id.review);
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
                        startActivity(new Intent(getApplicationContext(), AppointmentHome.class));
                        overridePendingTransition(0, 0);
                        finish();
                        return true;
                    case R.id.review:
                        return true;
                }
                return false;

            }
        });


        final ArrayList<DocReview>list1=new ArrayList<>();


        final Spinner docName = findViewById(R.id.spinner);
        review.keepSynced(true);
        review.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                if (dataSnapshot.exists()) {


                    for (DataSnapshot docSnapshot : dataSnapshot.getChildren()) {
                        final DocReview doctor = docSnapshot.getValue(DocReview.class);

                        list1.add(doctor);
                    }


                    ArrayAdapter<Doctor> adapter = new ArrayAdapter(DoctorReview.this, android.R.layout.simple_spinner_item, list1);
                    adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                    docName.setAdapter(adapter);

                }else {
                    new SweetAlertDialog(DoctorReview.this, SweetAlertDialog.WARNING_TYPE)
                            .setTitleText("Opps! You have no review yet")
                            .show();
                }
            }

            @Override
            public void onCancelled(@NonNull DatabaseError databaseError) {


            }
        });
        docName.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            public void onItemSelected(AdapterView<?> parent, View view, int pos, long id) {
                DocReview doctor=list1.get(pos);
                String date=doctor.getDate();
                Recordinfo(date);


            }
            public void onNothingSelected(AdapterView<?> parent) {
            }
        });




    }

    private void Recordinfo(String date) {
        FirebaseUser user= FirebaseAuth.getInstance().getCurrentUser();
        final String uid = user.getUid();
        review2= FirebaseDatabase.getInstance().getReference("DoctorReview").child(uid).child(date);
        review2.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {

                if (dataSnapshot.exists()) {
                    DocReview review = dataSnapshot.getValue(DocReview.class);

                    BloodPressure.setText(review.getBloodpressure());
                    BloodSugar.setText(review.getBloodsugar());
                    Weight.setText(review.getWeight());
                    Comment.setText(review.getComment());

                } else{
                    SweetAlertDialog progressDialog= new SweetAlertDialog(DoctorReview.this, SweetAlertDialog.WARNING_TYPE);
                    progressDialog.setTitleText("Opps! No Review Yet");
                    if (!isFinishing()) {
                        progressDialog.show();
                    }
                }


            }

            @Override
            public void onCancelled(@NonNull DatabaseError databaseError) {
                Log.e("problem",databaseError.getMessage());

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
                DoctorReview.super.onBackPressed();
            }
        });
        progressDialog.show();
    }
}