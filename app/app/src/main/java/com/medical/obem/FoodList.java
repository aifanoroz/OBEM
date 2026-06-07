package com.medical.obem;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.widget.EditText;
import android.widget.Toast;

import com.medical.obem.model.Food;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;
import java.util.List;

public class FoodList extends AppCompatActivity {

    RecyclerView recyclerView;
    List<Food> fData;
    SearchAdapter foodAdapter;
    EditText searchInput ;
    CharSequence search="";
    ConstraintLayout rootLayout;
    private DatabaseReference ref_eat;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_food_list);
        recyclerView = findViewById(R.id.food);
        fData = new ArrayList<>();
        rootLayout = findViewById(R.id.root_layout);
        searchInput = findViewById(R.id.search_input);

        FirebaseDatabase database = FirebaseDatabase.getInstance();
        ref_eat = database.getReference("Food List");

        ref_eat.keepSynced(true);
        ref_eat.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {

                for(DataSnapshot historySnapShot: dataSnapshot.getChildren()) {
                    Food eat = historySnapShot.getValue(Food.class);
                        fData.add(eat);

                }
                // listView

                foodAdapter = new SearchAdapter(FoodList.this,fData);
                recyclerView.setAdapter(foodAdapter);
                recyclerView.setLayoutManager(new LinearLayoutManager(getApplicationContext()));
            }

            @Override
            public void onCancelled(DatabaseError databaseError) {
                if(databaseError != null) {
                    Toast.makeText(FoodList.this,databaseError.getMessage(),Toast.LENGTH_LONG).show();
                }
            }
        });

        foodAdapter = new SearchAdapter(FoodList.this,fData);
        recyclerView.setAdapter(foodAdapter);

        searchInput.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {


                foodAdapter.getFilter().filter(s);
                search = s;


            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });




//        recyclerView.addOnItemTouchListener(new RecyclerItemClickListener(this, new RecyclerItemClickListener.OnItemClickListener() {
//            public void onItemClick(View view, int position) {
//                Food food = list.get(position);
//
//                intent.putExtra("food", food.getFood());
//                intent.putExtra("calories", food.getCalories());
//                startActivity(intent);
//            }
//        }));


    }
}