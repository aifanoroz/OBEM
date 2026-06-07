package com.medical.obem;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.widget.EditText;
import android.widget.Toast;

import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.medical.obem.model.Appointment;

import java.util.ArrayList;
import java.util.List;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class AppointmentHistory extends AppCompatActivity {
    RecyclerView recyclerView;
    List<Appointment> appointData;
    AppointmentAdapter appointmentAdapter;
    EditText searchInput ;
    CharSequence search="";
    ConstraintLayout rootLayout;
    private DatabaseReference ref;
    FirebaseAuth mAuth = FirebaseAuth.getInstance();
    FirebaseUser user = mAuth.getCurrentUser();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_appointment_history);
        recyclerView = findViewById(R.id.apphistory);
        appointData= new ArrayList<>();
        rootLayout = findViewById(R.id.root_layout);
        searchInput = findViewById(R.id.search_input);


        FirebaseDatabase database = FirebaseDatabase.getInstance();
        ref = database.getReference("AppointmentHistory").child(user.getUid());

        ref.keepSynced(true);
        ref.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                if (dataSnapshot.exists()) {

                    for (DataSnapshot historySnapShot : dataSnapshot.getChildren()) {
                        Appointment appoint = historySnapShot.getValue(Appointment.class);
                        appointData.add(appoint);

                    }
                    // listView

                    appointmentAdapter = new AppointmentAdapter(AppointmentHistory.this, appointData);
                    recyclerView.setAdapter(appointmentAdapter);
                    recyclerView.setLayoutManager(new LinearLayoutManager(getApplicationContext()));
                }else{
                    SweetAlertDialog progressDialog= new SweetAlertDialog(AppointmentHistory.this, SweetAlertDialog.WARNING_TYPE);
                    progressDialog.setTitleText("Opps! No history available");
                    progressDialog.setConfirmText("Ok");
                    progressDialog.setCanceledOnTouchOutside(false);
                    progressDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
                        @Override
                        public void onClick(SweetAlertDialog sweetAlertDialog) {
                            sweetAlertDialog.dismiss();
                            Intent intent = new Intent(getApplicationContext(), AppointmentHome.class);
                            startActivity(intent);

                        }
                    });
                    if (!isFinishing()) {
                        progressDialog.show();
                    }
                }
            }

            @Override
            public void onCancelled(DatabaseError databaseError) {
                if(databaseError != null) {
                    Toast.makeText(AppointmentHistory.this,databaseError.getMessage(),Toast.LENGTH_LONG).show();
                }
            }
        });
        appointmentAdapter = new AppointmentAdapter(AppointmentHistory.this,appointData);
        recyclerView.setAdapter(appointmentAdapter);

        searchInput.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {


                appointmentAdapter.getFilter().filter(s);
                search = s;


            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });
    }



}