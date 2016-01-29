import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.event.ActionEvent;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import java.util.InputMismatchException;
import java.util.Scanner;

import javax.swing.AbstractAction;

import javax.swing.BorderFactory;
import javax.swing.Box;
import javax.swing.BoxLayout;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JComponent;
import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTextArea;

import com.sun.org.apache.bcel.internal.generic.RETURN;

/**
 * This is the main class for the program TaskerCli, developed for
 * the CS22120 group project, by group 07.
 * 
 * This class is the centre of the program. It stores all of the 
 * tasks for the user and initialises the main components of the GUI.
 * The �main screen� is supposed to provide a list of buttons, one
 * for each class, that once pressed interacts with the given task 
 * object and loads the task into the GUI. This class provides a 
 * reference to the �synchroniser� so that when necessary, tasks can 
 * be loaded, synchronised or saved.

 * 
 * @author Group 07: kuh1, 
 * @version 0.2
 * @date 28/11/2015
 *
 */
public class TaskerCli {
	
	private ArrayList<Task> tasks;
	private Synchroniser synchroniser;
	private JFrame gui;
	private MainScreen mainScreen;
	
	/**
	 * Starts the program by initialising the login screen.
	 * @param args
	 */
	public static void main(String [] args){
		TaskerCli tasker = new TaskerCli();
		tasker.initialiseLoginScreen();
	}
	
	/**
	 * Initialises the GUI that allows the user to log in.
	 */
	public void initialiseLoginScreen(){
		//NEED CODE FOR REMEMBERED EMAIL
		
		//Create a new GUI frame
		gui = new JFrame("TaskerCli: Login");
		//Make sure the frame closes as expected
		gui.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		
		//Add the login screen panel
        LoginScreen loginScreen = new LoginScreen(this, readLastEmail());
        gui.add(loginScreen);
        
        //Make sure the GUI is visible
        gui.setSize(700, 300);
        gui.setVisible(true);
    }
	
	/**
	 * Initialises the GUI after the user has successfully
	 * logged in. 
	 */
	public void initialiseMainScreen(){
		//Create a new GUI frame
		gui.dispose();
		gui = new JFrame("TaskerCli");
		//Make sure the frame closes as expected
		gui.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
				
		//Add the main panel
		mainScreen = new MainScreen(this, tasks);
		gui.add(mainScreen);
		        
		//Make sure the GUI is visible
		gui.setSize(1200, 800);
		gui.setVisible(true);
	}
	
	/**
	 * Called by pressing the �log in� button on the GUI. 
	 * Creates a new synchroniser with the input email.
	 * Attempts to load the relevant tasks from local storage
	 * and then synchronise them with the tasks on TaskerSvr.
	 * If successful the main screen GUI is loaded. If no
	 * tasks could be retrieved an error message is output
	 * and the user has to try a different email to continue.
	 * I.E ALL ERROR CHECKING OF EMAIL DONE HERE, NOT IN GUI CLASS
	 * @param userEmail
	 * 				The input email address.
	 * @param doRemember
	 * 				Save the email address for next time?
	 */
	public void login(String userEmail, boolean doRemember){
		//Create a new synchroniser for this user so we can attempt to retrieve the data
		synchroniser = new Synchroniser(userEmail, this);
		//First try to load the local data, then attempt to synchronise with TaskerSvr
		tasks = synchroniser.retrieveTasksFromLocal();
		tasks = synchroniser.synchroniseTasks(tasks);
			
		if(doRemember && tasks != null && tasks.size() > 0){
			saveLastEmail(userEmail);
		}else{
			saveLastEmail("");
		}
		
		/*If there were no tasks found... In future I want to catch a specific exception
		 * and flash an error message.*/
		if(tasks == null || tasks.size() == 0){
			//Null the synchroniser so we can start again.
			synchroniser = null;
			//Output error message
			JOptionPane.showMessageDialog(new JFrame("Error"), "Sorry but no data could be found, try a different email");
		}else{
			//We can now load the second user interface
			initialiseMainScreen();
		}
	}
	
	/**
	 * Calls the synchroniser to synchronise tasks. Allows a
	 * task object to request changes made to be saved.
	 */
	public void saveChanges(){
		tasks = synchroniser.synchroniseTasks(tasks);
		mainScreen.refreshTaskMenu(tasks);
		//We want to remove the task panel if no longer allocated
		mainScreen.refereshTaskPanel();
	}

	/**
	 * 
	 */
	void cancelChanges(){
		//Here we want to reset the task panel
		mainScreen.resetTaskPanel();
	}
	
	/*
	 * Save the input email into a file 'lastEmail.txt' to be recalled next time the program
	 * is run.
	 */
	private void saveLastEmail(String email){System.out.println(email);
		//Create a file writer
		try(FileWriter fw = new FileWriter("lastEmail.txt");
			BufferedWriter bw = new BufferedWriter(fw);
			PrintWriter outfile = new PrintWriter(bw);){

			//Output user email on the first line
			outfile.println(email);
		} catch (IOException e) {
			System.err.println("Problem when trying to save last email");
		}
	}
	
	/*
	 * Reads the email file to see if the last email input was saved.
	 */
	private String readLastEmail(){
		String lastEmail;
		
		//Try to read from the users file
		try(FileReader fr = new FileReader("lastEmail.txt");
			BufferedReader br = new BufferedReader(fr);
			Scanner infile = new Scanner(br)){
					
			lastEmail = infile.nextLine();
			
			//Catch the various possible errors, such as the user not having a file
			} catch (FileNotFoundException nf){
				saveLastEmail("");
				return null;
			} catch (Exception e) {
				System.out.println("Error loading last email: " + e.toString());
				saveLastEmail("");
				return null;
			}
		
		return lastEmail;
	}
	
	/* *******************************************************************************
	 * 							END OF MAIN CLASS 'TaskerCli'				     *
	 * 						 START OF INNER CLASS 'LoginScreen'					 *
	 * *******************************************************************************/
	
	
	/**
	 * This class provides a JPanel that displays the login screen.
	 * The user has a text box to input their email, a checkbox to confirm
	 * if they want that email to be remembered, and a button to confirm
	 * they want to login using the input email.
	 * @author kuh1
	 */
	private class LoginScreen extends JPanel{
		private TaskerCli tasker;
		//The box for the user to type their email
        private JTextArea loginInput;
        //The box that lets the user choose if to store their email for next time or not
        private JCheckBox doRemember;
        //The last saved email, if there is one
        private String lastEmail;
		
		/**
		 * Create the panel for the login screen
		 * @param taskerCli
		 * 				The instance of the main class that the GUI will interact with to "login"
		 */
		LoginScreen(TaskerCli taskerCli, String lastEmail){
			super();
			
			tasker = taskerCli;
			this.lastEmail = lastEmail;
	
			//Set the layout of the panel and populate it
			setLayout(new BoxLayout(this, BoxLayout.PAGE_AXIS));
			populatePanel();
			
			//Make sure it is visible
			setVisible(true); 
		}
		
		/**
		 * Add the individual elements to the panel that will make up the login screen
		 */
		private void populatePanel(){
			//Add padding between the below element and the window edge
			add(Box.createVerticalGlue());
			
			//Add a welcome message
          	JSLabel title = new JSLabel("Welcome,", "Arial", Font.PLAIN, 20);
          	addCentral(title, 20);
          	
          	//Add instruction message
           	JSLabel instructions = new JSLabel("Please input your email address below:", "Arial", Font.PLAIN, 20);
           	addCentral(instructions, 5);
           	
          	//Add input box for the user to input login email
         	loginInput = new JTextArea();
         	//Make sure it has a visually appealing size and look
           	loginInput.setMaximumSize(new Dimension(390, 40));
           	loginInput.setPreferredSize(new Dimension(390, 40));
           	loginInput.setBorder(BorderFactory.createMatteBorder(2, 2, 2, 2, Color.DARK_GRAY));
           	//Display the last input email
           	loginInput.setText(lastEmail);
           	loginInput.setFont(new Font("Arial", Font.PLAIN, 16));
           	addCentral(loginInput, 20);
           	
           	//Add the input box for asking if the user wants their email to be remembered
           	add(createRememberBox());          	
           	
          	//Add button to confirm login
           	JButton loginBtn = createLoginBtn();
           	addCentral(loginBtn, 0);
           	
            //Add padding between the below element and the window edge
           	add(Box.createVerticalGlue());
		}
		
		/**
		 * Adds the given component to the panel, aligning it centrally and adding
		 * the given amount of padding below. 
		 * @param theComp
		 * 				The componenet to add
		 * @param vertPadding
		 * 				The amont of padding to add after the componenet
		 */
		private void addCentral(JComponent theComp, int vertPadding){
			theComp.setAlignmentX(Component.CENTER_ALIGNMENT);
			add(theComp);
			
			if(vertPadding > 0){
				//Add padding below this element
	            add(Box.createRigidArea(new Dimension(0,vertPadding)));
			}
		}
        
		/**
		 * Creates a panel with a label and checkbox in line asking if the user
		 * wants their email remembered
		 * @return
		 *  	A panel containing the two componenets in line
		 */
		private JPanel createRememberBox(){
			JPanel panel = new JPanel();
			
			//Add the question
          	JSLabel question = new JSLabel("Remember email?: ", "Arial", Font.PLAIN, 20);
          	panel.add(question);
          	
          	//Add the checkbox
          	doRemember = new JCheckBox();
          	panel.add(doRemember);
			
			return panel;
		}
		
        /**
        * Creates the button the user will press to login
        * @return 
        */
        private JButton createLoginBtn(){
            //Create a new button and define its behaviour
        	JButton loginBtn = new JButton(new AbstractAction("Login") {
        		public void actionPerformed(ActionEvent ae) {
        			//Send taskerCli the input email address
        			//It is NOT this classes responsibility to check for errors
        			tasker.login(loginInput.getText(), doRemember.isSelected());
        		}
        	});
                   
        	return loginBtn;
        }
	}
}
