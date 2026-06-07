package com.medical.obem;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.AnimationUtils;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.medical.obem.model.Appointment;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;
import java.util.List;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class AppointmentAdapter extends RecyclerView.Adapter<AppointmentAdapter.NewsViewHolder> implements Filterable {
    final String uid = FirebaseAuth.getInstance().getCurrentUser().getUid();
    DatabaseReference ref = FirebaseDatabase.getInstance().getReference("AppointmentHistory").child(uid);

    Activity mContext;
    List<Appointment> mData ;
    List<Appointment> mDataFiltered ;
    ArrayList<Appointment> appointmentArrayList=new ArrayList<>();





    public AppointmentAdapter(Activity mContext, List<Appointment> mData) {
        this.mContext = mContext;
        this.mData = mData;
        this.mDataFiltered = mData;

    }



    @NonNull
    @Override
    public NewsViewHolder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {

        View layout;
        layout = LayoutInflater.from(mContext).inflate(R.layout.appointment_search,viewGroup,false);
        return new NewsViewHolder(layout);
    }

    @Override
    public void onBindViewHolder(@NonNull final NewsViewHolder newsViewHolder, final int position) {
        final Appointment appoin = mDataFiltered.get(position);
        final String time= appoin.getTime();
        final String date= appoin.getDate();
        if (mDataFiltered.get(position).getDoctorStatus()==2){
            newsViewHolder.Status.setTextColor(Color.parseColor("#23C552"));
            newsViewHolder.Status.setText("Status : "+"Completed");
        }
        else
        {
            newsViewHolder.Status.setTextColor(Color.parseColor("#ff1616"));
            newsViewHolder.Status.setText("Status : "+"Cancelled");
        }
        newsViewHolder.tv_title.setText(mDataFiltered.get(position).getDate());
        newsViewHolder.tv_content.setText("Time : "+mDataFiltered.get(position).getTime());
        newsViewHolder.Doctor.setText("Doctor Name : "+mDataFiltered.get(position).getDocname());

        newsViewHolder.container.setAnimation(AnimationUtils.loadAnimation(mContext,R.anim.fade_scale_animation));


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
                    List<Appointment> lstFiltered = new ArrayList<>();
                    for (Appointment row : mData) {

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


                mDataFiltered = (List<Appointment>) results.values;
                notifyDataSetChanged();

            }
        };




    }

    public class NewsViewHolder extends RecyclerView.ViewHolder {



        TextView tv_title,tv_content,Doctor,Status;
        RelativeLayout container;





        public NewsViewHolder(@NonNull View itemView) {
            super(itemView);
            container = itemView.findViewById(R.id.container);
            tv_title = itemView.findViewById(R.id.tv_title);
            tv_content = itemView.findViewById(R.id.tv_description);
            Doctor = itemView.findViewById(R.id.doctor);
            Status = itemView.findViewById(R.id.status);




        }





    }
}
