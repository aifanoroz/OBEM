package com.medical.obem;

import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.text.InputType;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TimePicker;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.medical.obem.model.Doctor;
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

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;

import cn.pedant.SweetAlert.SweetAlertDialog;
import es.dmoral.toasty.Toasty;
import com.medical.obem.model.Appointment;
import com.medical.obem.model.History;

public class AppointmentActivity extends AppCompatActivity {


    private static final String TAG = AppointmentActivity.class.getSimpleName();
    private Button submit;
    EditText date_in;
    EditText time_in;
    private String date,time;
    private DatabaseReference ref;
    ArrayList<Appointment> appointmentArrayList;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_appointment);
        submit=findViewById(R.id.submit);
        date_in=findViewById(R.id.date_input);
        time_in=findViewById(R.id.time_input);
        date_in.setInputType(InputType.TYPE_NULL);
        time_in.setInputType(InputType.TYPE_NULL);
        appointmentArrayList = new ArrayList<>();


        date_in.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showDateDialog(date_in);
            }
        });

        time_in.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showTimeDialog(time_in);
            }
        });




        final ArrayList<Doctor>list1=new ArrayList<>();

        FirebaseDatabase database = FirebaseDatabase.getInstance();
        DatabaseReference doc = database.getReference("Doctor");
        final Spinner docName = findViewById(R.id.spinner);
        doc.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {


                 list1.clear();
                for (DataSnapshot docSnapshot: dataSnapshot.getChildren()) {
                    final Doctor doctor = docSnapshot.getValue(Doctor.class);

                    list1.add(doctor);

                }



                ArrayAdapter<Doctor> adapter = new ArrayAdapter(AppointmentActivity.this, android.R.layout.simple_spinner_item, list1);
                adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                docName.setAdapter(adapter);


            }

            @Override
            public void onCancelled(@NonNull DatabaseError databaseError) {
                Log.e(TAG,databaseError.getMessage());

            }
        });

        docName.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            public void onItemSelected(AdapterView<?> parent, View view, int pos, long id) {
                Doctor doctor=list1.get(pos);
                String name=doctor.getName();
                String specialization=doctor.getSpecialization();
                String key=doctor.getKey();
                Recordinfo(name,specialization,key);


            }
            public void onNothingSelected(AdapterView<?> parent) {
            }
        });

    }

    private void showTimeDialog(final EditText time_in) {
        final Calendar calendar=Calendar.getInstance();

        TimePickerDialog.OnTimeSetListener timeSetListener=new TimePickerDialog.OnTimeSetListener() {
            @Override
            public void onTimeSet(TimePicker view, int hourOfDay, int minute) {
                calendar.set(Calendar.HOUR_OF_DAY,hourOfDay);
                calendar.set(Calendar.MINUTE,minute);
                SimpleDateFormat simpleDateFormat=new SimpleDateFormat("HH:mm");
                time_in.setText(simpleDateFormat.format(calendar.getTime()));
                time=simpleDateFormat.format(calendar.getTime());
            }
        };

        new TimePickerDialog(AppointmentActivity.this,timeSetListener,calendar.get(Calendar.HOUR_OF_DAY),calendar.get(Calendar.MINUTE),false).show();

    }

    private void showDateDialog(final EditText date_in) {
        final Calendar calendar=Calendar.getInstance();
        DatePickerDialog.OnDateSetListener dateSetListener=new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                calendar.set(Calendar.YEAR,year);
                calendar.set(Calendar.MONTH,month);
                calendar.set(Calendar.DAY_OF_MONTH,dayOfMonth);
                SimpleDateFormat simpleDateFormat=new SimpleDateFormat("yyyy-MM-dd");
                date_in.setText(simpleDateFormat.format(calendar.getTime()));
              date=simpleDateFormat.format(calendar.getTime());

            }
        };

        new DatePickerDialog(AppointmentActivity.this,dateSetListener,calendar.get(Calendar.YEAR),calendar.get(Calendar.MONTH),calendar.get(Calendar.DAY_OF_MONTH)).show();
    }

    private void Recordinfo(final String name, final String specialization,final String key) {

        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (name==null){
                    Toasty.error(getApplicationContext(),"Select Doctor",Toast.LENGTH_SHORT).show();
                }
                else if (date==null){

                    Toasty.error(getApplicationContext(), "Enter Date", Toast.LENGTH_SHORT).show();
                }
                else if (time==null){

                    Toasty.error(getApplicationContext(), "Enter time", Toast.LENGTH_SHORT).show();
                }
                else {
                    FirebaseUser user = FirebaseAuth.getInstance().getCurrentUser();
                    FirebaseDatabase database = FirebaseDatabase.getInstance();
                    ref = database.getReference("Appointment").child(user.getUid());
                    ref.keepSynced(true);
                    ref.addListenerForSingleValueEvent(new ValueEventListener() {
                        @Override
                        public void onDataChange(DataSnapshot dataSnapshot) {
                            if (dataSnapshot.exists()) {
                                Appointment appoint = dataSnapshot.getValue(Appointment.class);
                                int status = appoint.getDoctorStatus();
                                if (status == 1) {
                                    new SweetAlertDialog(AppointmentActivity.this, SweetAlertDialog.WARNING_TYPE)
                                            .setTitleText("Opps! You have an active appointment")
                                            .show();

                                } else {
                                    int userStatus = 1;
                                    int doctorStatus = 1;
                                    FirebaseUser user = FirebaseAuth.getInstance().getCurrentUser();

                                    HashMap<String, Object> Appointment = new HashMap<>();
                                    Appointment.put("Username", user.getDisplayName());
                                    Appointment.put("Docname", name);
                                    Appointment.put("specialization", specialization);
                                    Appointment.put("date", date);
                                    Appointment.put("time", time);
                                    Appointment.put("uid", user.getUid());
                                    Appointment.put("userStatus", userStatus);
                                    Appointment.put("doctorStatus", doctorStatus);
                                    Appointment.put("key", key);
                                    DatabaseReference ref = FirebaseDatabase.getInstance().getReference("Appointment").child(user.getUid());
                                    ref.setValue(Appointment).addOnCompleteListener(new OnCompleteListener<Void>() {
                                        @Override
                                        public void onComplete(@NonNull final Task<Void> task) {
                                            SweetAlertDialog progressDialog= new SweetAlertDialog(AppointmentActivity.this, SweetAlertDialog.SUCCESS_TYPE);
                                            progressDialog.setTitleText("Appointment Booked");
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
                                            progressDialog.show();
                                        }

                                    });
                                }
                            }else{
                                int userStatus = 1;
                                int doctorStatus = 1;
                                FirebaseUser user = FirebaseAuth.getInstance().getCurrentUser();

                                HashMap<String, Object> Appointment = new HashMap<>();
                                Appointment.put("Username", user.getDisplayName());
                                Appointment.put("Docname", name);
                                Appointment.put("specialization", specialization);
                                Appointment.put("date", date);
                                Appointment.put("time", time);
                                Appointment.put("uid", user.getUid());
                                Appointment.put("userStatus", userStatus);
                                Appointment.put("doctorStatus", doctorStatus);
                                Appointment.put("key", key);
                                DatabaseReference ref = FirebaseDatabase.getInstance().getReference("Appointment").child(user.getUid());
                                ref.setValue(Appointment).addOnCompleteListener(new OnCompleteListener<Void>() {
                                    @Override
                                    public void onComplete(@NonNull Task<Void> task) {
                                        SweetAlertDialog progressDialog= new SweetAlertDialog(AppointmentActivity.this, SweetAlertDialog.SUCCESS_TYPE);
                                        progressDialog.setTitleText("Appointment Booked");
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
                                        progressDialog.show();

                                    }
                                });

                            }

                        }


                        @Override
                        public void onCancelled(DatabaseError databaseError) {
                            if (databaseError != null) {

                            }
                        }
                    });

                }




            }
        });

    }





}