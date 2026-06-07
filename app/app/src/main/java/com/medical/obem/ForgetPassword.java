package com.medical.obem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.NotificationCompat;
import androidx.core.app.NotificationManagerCompat;

import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;


import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;


import java.text.SimpleDateFormat;
import java.util.Date;

import es.dmoral.toasty.Toasty;

public class ForgetPassword extends AppCompatActivity {
    private EditText Email;
    private Button login;
    private ProgressBar loading;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forget_password);
        Email = findViewById(R.id.email);
        login = findViewById(R.id.login);
        loading=findViewById(R.id.progressBar);
        loading.setVisibility(View.INVISIBLE);
        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                login.setVisibility(View.INVISIBLE);
                loading.setVisibility(View.VISIBLE);

                String emaill = Email.getText().toString().trim();

                boolean flag=false;

                if (emaill.isEmpty()) {
                    flag= true;
                    Email.setError("Fields can't be empty");
                    login.setVisibility(View.VISIBLE);
                    loading.setVisibility(View.INVISIBLE);

                }

                if(flag == false){
                    // if everything is fine, sign in
                    Email.setError(null);


                    Reset(emaill);



                }
            }

        });





    }

    private void Reset(String emaill) {
        FirebaseAuth auth = FirebaseAuth.getInstance();
        auth.sendPasswordResetEmail(emaill).addOnCompleteListener(new OnCompleteListener<Void>() {
            @Override
            public void onComplete(@NonNull Task<Void> task) {
                startActivity(new Intent(getApplicationContext(), MainActivity.class));
                Toasty.success(getApplicationContext(),"Password reset complete", Toasty.LENGTH_SHORT).show();
                finish();
            }
        });
    }
}