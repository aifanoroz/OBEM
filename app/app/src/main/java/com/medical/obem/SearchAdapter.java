package com.medical.obem;

import android.app.Activity;
import android.app.Dialog;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseUser;
import com.medical.obem.model.Food;
import com.medical.obem.model.History;
import com.medical.obem.model.Overview;
import com.medical.obem.model.UserHealth;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;

public class SearchAdapter extends RecyclerView.Adapter<SearchAdapter.NewsViewHolder> implements Filterable {
    final String uid = FirebaseAuth.getInstance().getCurrentUser().getUid();
    DatabaseReference Overview = FirebaseDatabase.getInstance().getReference("overview").child(uid);

    Activity mContext;
    List<Food> mData ;
    List<Food> mDataFiltered ;
    int sumOfEatCal = 0;
    int currentCalories;
    Dialog myDialog;




    public SearchAdapter(Activity mContext, List<Food> mData) {
        this.mContext = mContext;
        this.mData = mData;
        this.mDataFiltered = mData;

    }



    @NonNull
    @Override
    public NewsViewHolder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {

        View layout;
        layout = LayoutInflater.from(mContext).inflate(R.layout.food_search,viewGroup,false);
        return new NewsViewHolder(layout);
    }

    @Override
    public void onBindViewHolder(@NonNull final NewsViewHolder newsViewHolder, final int position) {
        Food food = mDataFiltered.get(position);
        final String calorie= Long.toString(food.getCalories());
        final String Food= food.getFood();
        DatabaseReference health = FirebaseDatabase.getInstance().getReference("Health Status").child("Patient").child(uid);
        newsViewHolder.tv_title.setText(mDataFiltered.get(position).getFood());
        newsViewHolder.tv_content.setText(mDataFiltered.get(position).getMeasure());
        newsViewHolder.Calorie.setText(calorie+" kcal");
        newsViewHolder.container.setAnimation(AnimationUtils.loadAnimation(mContext,R.anim.fade_scale_animation));
        health.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                UserHealth health = dataSnapshot.getValue(UserHealth.class);
                currentCalories =Integer.parseInt(health.getCalorie());
                if (health != null) {
                    DatabaseReference Overview = FirebaseDatabase.getInstance().getReference("overview").child(uid);
                    Overview.keepSynced(true);
                    Overview.addValueEventListener(new ValueEventListener() {
                        @Override
                        public void onDataChange(DataSnapshot dataSnapshot)
                        {


                            if (dataSnapshot.exists())
                            {
                                Overview overview = dataSnapshot.getValue(Overview.class);
                                sumOfEatCal = overview.getSumOfEatCal();

                                final int remaining=currentCalories-sumOfEatCal;
                                if (remaining<Integer.parseInt(calorie)){



                                    newsViewHolder.Status.setTextColor(Color.parseColor("#ff1616"));
                                    newsViewHolder.Status.setText("NOT SUGGESTED");

                                }else
                                {

                                    newsViewHolder.Status.setTextColor(Color.parseColor("#23C552"));
                                    newsViewHolder.Status.setText("SUGGESTED");
                                }



                            }
                            else {

                                newsViewHolder.tv_title.setText(mDataFiltered.get(position).getFood());
                                newsViewHolder.tv_content.setText(mDataFiltered.get(position).getMeasure());
                                newsViewHolder.Calorie.setText(calorie+" kcal");

                            }

                        }

                        @Override
                        public void onCancelled(DatabaseError databaseError) {

                        }
                    });

                }
                else
                {

                    newsViewHolder.tv_title.setText(mDataFiltered.get(position).getFood());
                    newsViewHolder.tv_content.setText(mDataFiltered.get(position).getMeasure());
                    newsViewHolder.Calorie.setText(calorie+" kcal");
                }


            }

            @Override
            public void onCancelled(DatabaseError databaseError) {

            }
        });



        newsViewHolder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Food food = mDataFiltered.get(position);

                final String Food= food.getFood();
                final String calorie= Long.toString(food.getCalories());
                myDialog = new Dialog(mContext);
                myDialog.setContentView(R.layout.custompopup);
                TextView txtclose,foodd,caloriee;
                final EditText measure;
                Button submit;

                txtclose =(TextView) myDialog.findViewById(R.id.txtclose);
                txtclose.setText("X");
                measure =  myDialog.findViewById(R.id.measure);



                final int Calorie = Integer.parseInt(calorie);
                submit= myDialog.findViewById(R.id.submit);
                foodd =myDialog.findViewById(R.id.food);
                caloriee=myDialog.findViewById(R.id.calorie);
                caloriee.setText(calorie);
                foodd.setText(Food);
                submit.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        try{
                            String Measure=measure.getText().toString();
                            int i = Integer.parseInt(Measure);
                            passData(Food,Calorie,i);
                        } catch(NumberFormatException ex){ // handle your exception
                            System.out.println(ex.getMessage());
                        }

                    }
                });
                txtclose.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        myDialog.dismiss();
                    }
                });

                myDialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
                myDialog.show();

            }
        });



    }


    private void passData(String food, int calorie, int Measure) {
       DatabaseReference ref_history;
        Date today = new Date();
        FirebaseDatabase database = FirebaseDatabase.getInstance();
        ref_history = database.getReference("Calorie history");


        final String date = today.getYear()+1900 + "-" + (1+today.getMonth()) + "-" + today.getDate();


        FirebaseUser user= FirebaseAuth.getInstance().getCurrentUser();
        int full=Measure * calorie;
        String total = String.valueOf(full);
        String eat = food;
        String id = ref_history.push().getKey();
        String uid = user.getUid();



        final HashMap<String, Object> History = new HashMap<>();
        History.put("id",id);
        History.put("item",eat);
        History.put("totalCalories",total);
        History.put("date",date);


        ref_history.child(date).child(uid).child(id).setValue(History).addOnCompleteListener(new OnCompleteListener<Void>() {
            @Override
            public void onComplete(@NonNull Task<Void> task) {
                Intent intent = new Intent(mContext, HistoryController.class);
                mContext.startActivity(intent);
                mContext.finish();
            }
        });

    }

    @Override
    public int getItemCount() {
        return mDataFiltered.size();
    }

    @Override
    public Filter getFilter() {

        return new Filter() {
            @Override
            protected FilterResults performFiltering(CharSequence constraint) {

                String Key = constraint.toString();
                if (Key.isEmpty()) {

                    mDataFiltered = mData ;

                }
                else {
                    List<Food> lstFiltered = new ArrayList<>();
                    for (Food row : mData) {

                        if (row.getFood().toLowerCase().contains(Key.toLowerCase())){
                            lstFiltered.add(row);
                        }

                    }

                    mDataFiltered = lstFiltered;

                }


                FilterResults filterResults = new FilterResults();
                filterResults.values= mDataFiltered;
                return filterResults;

            }

            @Override
            protected void publishResults(CharSequence constraint, FilterResults results) {


                mDataFiltered = (List<Food>) results.values;
                notifyDataSetChanged();

            }
        };




    }

    public class NewsViewHolder extends RecyclerView.ViewHolder {



        TextView tv_title,tv_content,Calorie,Status;
        RelativeLayout container;





        public NewsViewHolder(@NonNull View itemView) {
            super(itemView);
            container = itemView.findViewById(R.id.container);
            tv_title = itemView.findViewById(R.id.tv_title);
            tv_content = itemView.findViewById(R.id.tv_description);
            Calorie = itemView.findViewById(R.id.calorie);
            Status = itemView.findViewById(R.id.status);




        }





    }
}
