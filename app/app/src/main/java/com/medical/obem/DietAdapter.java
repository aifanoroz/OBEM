package com.medical.obem;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.view.LayoutInflater;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.medical.obem.model.Appointment;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.medical.obem.model.Food;
import com.medical.obem.model.History;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class DietAdapter extends RecyclerView.Adapter<DietAdapter.NewsViewHolder> implements Filterable {
    final String uid = FirebaseAuth.getInstance().getCurrentUser().getUid();
    Date today = new Date();
    String date = today.getYear()+1900 + "-" + (1+today.getMonth()) + "-" + today.getDate();
    DatabaseReference ref_history= FirebaseDatabase.getInstance().getReference("Calorie history").child(date).child(uid);
    DatabaseReference ref_history2=FirebaseDatabase.getInstance().getReference("Calorie history");
    Activity mContext;
    List<History> mData ;
    List<History> mDataFiltered ;
    ArrayList<History> historyArrayList=new ArrayList<>();





    public DietAdapter(Activity mContext, List<History> mData) {
        this.mContext = mContext;
        this.mData = mData;
        this.mDataFiltered = mData;

    }



    @NonNull
    @Override
    public NewsViewHolder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {

        View layout;
        layout = LayoutInflater.from(mContext).inflate(R.layout.diet_history_search,viewGroup,false);
        return new NewsViewHolder(layout);
    }

    @Override
    public void onBindViewHolder(@NonNull final NewsViewHolder newsViewHolder, final int position) {

        newsViewHolder.tv_title.setText(mDataFiltered.get(position).getItem());
        newsViewHolder.tv_content.setText("Total Calorie : "+mDataFiltered.get(position).getTotalCalories());
        newsViewHolder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                History history = mDataFiltered.get(position);
                final String id = history.getId();

                //1. build dialog with custome layout
                // inflate custom view -> set it on builder
                AlertDialog.Builder builder = new AlertDialog.Builder(mContext);

                LayoutInflater inflater = mContext.getLayoutInflater();
                View dialogView = inflater.inflate(R.layout.dialog_history_delete,null);
                builder.setView(dialogView);


                //                        builder.setTitle("delete?");
                final AlertDialog alertDialog = builder.create();
                alertDialog.show();


                Button delete_btn = dialogView.findViewById(R.id.dialog_delete);
                delete_btn.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {

                        ref_history2.child(date).child(uid).child(id).removeValue();
                        alertDialog.dismiss();
                    }
                });

                Button cancel_btn = dialogView.findViewById(R.id.dialog_cancel);
                cancel_btn.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        alertDialog.dismiss();
                    }
                });

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
                    List<History> lstFiltered = new ArrayList<>();
                    for (History row : mData) {

                        if (row.getDate().toLowerCase().contains(Key.toLowerCase())){
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


                mDataFiltered = (List<History>) results.values;
                notifyDataSetChanged();

            }
        };




    }

    public class NewsViewHolder extends RecyclerView.ViewHolder {



        TextView tv_title,tv_content;
        RelativeLayout container;





        public NewsViewHolder(@NonNull View itemView) {
            super(itemView);
            container = itemView.findViewById(R.id.container);
            tv_title = itemView.findViewById(R.id.tv_title);
            tv_content = itemView.findViewById(R.id.calorie);




        }





    }
}
