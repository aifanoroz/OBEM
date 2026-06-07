package com.medical.obem;

import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.os.Build;

import androidx.core.app.NotificationCompat;

import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

public class NotificationReciever extends BroadcastReceiver {
    private static final String CHANNEL_ID = "CHANNEL_SAMPLE";
    @Override
    public void onReceive(final Context context, Intent intent) {
        FirebaseAuth mAuth = FirebaseAuth.getInstance();
        final FirebaseUser user = mAuth.getCurrentUser();


        // Get id & message
        final int notificationId = intent.getIntExtra("notificationId", 0);

        final String uid = FirebaseAuth.getInstance().getCurrentUser().getUid();
        // Call MainActivity when notification is tapped.
        Intent mainIntent = new Intent(context, UpdateHealthActivity.class);
        final PendingIntent contentIntent = PendingIntent.getActivity(context, 0, mainIntent, 0);
        // NotificationManager
        final NotificationManager notificationManager =
                (NotificationManager) context.getSystemService(Context.NOTIFICATION_SERVICE);

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            // For API 26 and above
            CharSequence channelName = "My Notification";
            int importance = NotificationManager.IMPORTANCE_DEFAULT;

            NotificationChannel channel = new NotificationChannel(CHANNEL_ID, channelName, importance);
            notificationManager.createNotificationChannel(channel);
        }

        DatabaseReference PatientDetail = FirebaseDatabase.getInstance().getReference("Health Status").child("Patient").child(uid);
            PatientDetail .addListenerForSingleValueEvent(new ValueEventListener() {
                @Override
                public void onDataChange(DataSnapshot dataSnapshot)
                {

                    if (dataSnapshot.exists())
                    {

                        NotificationCompat.Builder builder = new NotificationCompat.Builder(context, CHANNEL_ID)
                                .setSmallIcon(android.R.drawable.ic_dialog_info)
                                .setContentTitle(" Hello"+"\n"+user.getDisplayName()+" (WEEKLY UPDATE)")
                                .setContentText("Click to update this week's health status")
                                .setContentIntent(contentIntent)
                                .setPriority(NotificationCompat.PRIORITY_DEFAULT)
                                .setAutoCancel(true);

                        // Notify
                        notificationManager.notify(notificationId, builder.build());



                    }

                }

                @Override
                public void onCancelled(DatabaseError databaseError) {

                }
            });

        }
    }

