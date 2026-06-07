package com.medical.obem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TextView;


import com.github.ybq.android.spinkit.sprite.Sprite;
import com.github.ybq.android.spinkit.style.FadingCircle;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.android.material.textfield.TextInputEditText;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.auth.UserProfileChangeRequest;
import com.google.firebase.database.DatabaseReference;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class RegisterActivity extends AppCompatActivity {
    private TextView login;
    private Button register;
    private ProgressBar loading;
    private FirebaseAuth mAuth;
    private TextInputEditText name, email,pass,confirmpass;
    private DatabaseReference mDatabase;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        register=findViewById(R.id.register);
        name=findViewById(R.id.name);

        loading=findViewById(R.id.progressBar);
        loading.setVisibility(View.INVISIBLE);
        mAuth=FirebaseAuth.getInstance();

        Sprite FadingCircle = new FadingCircle();
        loading.setIndeterminateDrawable(FadingCircle);


        register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                register.setVisibility(View.INVISIBLE);
                loading.setVisibility(View.VISIBLE);
                String Name = name.getText().toString();

                boolean flag=false;
                if (Name.isEmpty()) {
                    flag= true;
                    name.setError("Fields can't be empty");
                    register.setVisibility(View.VISIBLE);
                    loading.setVisibility(View.INVISIBLE);
                }

                if(flag == false){
                    // if everything is fine, sign up
                    name.setError(null);

                    CreateAccount(Name);
                }

            }

        });
    }
    private void CreateAccount( String name) {
        FirebaseUser user = FirebaseAuth.getInstance().getCurrentUser();

        UserProfileChangeRequest profileUpdates = new UserProfileChangeRequest.Builder()
                .setDisplayName(name).build();

        user.updateProfile(profileUpdates);
        user.updateProfile(profileUpdates)
                .addOnCompleteListener(new OnCompleteListener<Void>() {
                    @Override
                    public void onComplete(@NonNull Task<Void> task) {
                        if (task.isSuccessful()) {
                            startActivity(new Intent(getApplicationContext(), HealthProfile.class));
                            finish();
                        }
                    }
                });


    }
    public void onBackPressed() {
        //super.onBackPressed();
        SweetAlertDialog progressDialog = new SweetAlertDialog(this, SweetAlertDialog.WARNING_TYPE);
        progressDialog.setCancelable(false);
        progressDialog.setTitleText("Are you sure you want to exit?");
        progressDialog.setCancelText("No");
        progressDialog.setConfirmText("Yes");
        progressDialog.setCanceledOnTouchOutside(true);
        progressDialog.setConfirmClickListener(new SweetAlertDialog.OnSweetClickListener() {
            @Override
            public void onClick(SweetAlertDialog sweetAlertDialog) {
                sweetAlertDialog.dismiss();
                finishAffinity();
                finish();
            }
        });
        progressDialog.show();
    }


}