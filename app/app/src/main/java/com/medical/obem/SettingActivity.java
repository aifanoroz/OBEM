package com.medical.obem;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;

public class SettingActivity extends AppCompatActivity {
    private TextView logout,name,ForgetPass,update;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_setting);
        logout=findViewById(R.id.logout);
        name=findViewById(R.id.username);
        ForgetPass=findViewById(R.id.cpass);
        update=findViewById(R.id.wu);


        logout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                FirebaseAuth.getInstance().signOut();
                finish();
                startActivity(new Intent(SettingActivity.this,MainActivity.class));


            }
        });
        ForgetPass.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(SettingActivity.this,ForgetPassword.class));
                finish();

            }
        });

        update.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(SettingActivity.this,UpdateHealthActivity.class));
                finish();
            }
        });


        FirebaseUser user=FirebaseAuth.getInstance().getCurrentUser();
        if (user !=null){
            String Name=user.getDisplayName();
            name.setText(Name);

        }

    }




}