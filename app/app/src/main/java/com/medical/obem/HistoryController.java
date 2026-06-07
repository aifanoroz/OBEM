package com.medical.obem;


import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CalendarView;
import android.widget.ListView;
import android.widget.TextView;

import com.applandeo.materialcalendarview.EventDay;
import com.applandeo.materialcalendarview.exceptions.OutOfDateRangeException;
import com.medical.obem.model.History;
import com.medical.obem.model.Overview;
import com.medical.obem.model.UserHealth;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

public class HistoryController extends AppCompatActivity {
    RecyclerView  historyRecyclerView;
   List<History> historyArrayList;
    DietAdapter dietAdapter;
    private DatabaseReference ref_history,ref_history2;
    private DatabaseReference ref_overview;
    private DatabaseReference ref_basicInfo;
    Date today = new Date();
    static int sumOfCalories;
    static int sumOfEatCal;
    FirebaseDatabase database = FirebaseDatabase.getInstance();
    TextView textView;
    private Button addFood;
    ConstraintLayout rootLayout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_history_controller);
        textView = findViewById(R.id.selectedDate);
        addFood = findViewById(R.id.addmore);
        String date = today.getYear()+1900 + "-" + (1+today.getMonth()) + "-" + today.getDate();
        rootLayout = findViewById(R.id.root_layout);
        historyArrayList = new ArrayList<>();



        ref_basicInfo = database.getReference("Health Status").child("Patient");
        historyRecyclerView = findViewById(R.id.historyListView);



        // Read from the database
        readFromTheDatabase(date);
        addFood.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(),FoodList.class);
                startActivity(intent);
                finish();
            }
        });



    }




    private void readFromTheDatabase(final String date) {
        FirebaseUser user=FirebaseAuth.getInstance().getCurrentUser();
       final String uid = user.getUid();

        ref_overview = database.getReference("overview").child(uid);
        ref_history= FirebaseDatabase.getInstance().getReference("Calorie history").child(date).child(uid);
        ref_history2=FirebaseDatabase.getInstance().getReference("Calorie history");
        ref_history.keepSynced(true);
        ref_history.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                historyArrayList.clear();

                for (DataSnapshot resultSnapshot: dataSnapshot.getChildren()) {
                    History commandObject = resultSnapshot.getValue(History.class);
                      historyArrayList.add(commandObject);

                }

                dietAdapter = new DietAdapter(HistoryController.this, historyArrayList);
                historyRecyclerView.setAdapter(dietAdapter);
                historyRecyclerView.setLayoutManager(new LinearLayoutManager(getApplicationContext()));
                //
                //find the amount of calories and set text and send to overview
                sumOfCalories = 0;

                sumOfEatCal = 0;

                for (int i =0; i < historyArrayList.size(); i++){
                    sumOfCalories += Integer.valueOf(historyArrayList.get(i).getTotalCalories());
                    if(Integer.valueOf(historyArrayList.get(i).getTotalCalories())>0){
                        sumOfEatCal += Integer.valueOf(historyArrayList.get(i).getTotalCalories());
                    }else{
                        Log.e("status","problem");
                    }
                }



                Overview overview = new Overview(sumOfEatCal);
                ref_overview.setValue(overview);
                textView.setText(date);

            }

            @Override
            public void onCancelled(DatabaseError databaseError) {
                throw databaseError.toException();
            }
        });


    }


}
