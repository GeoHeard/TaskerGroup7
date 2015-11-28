import java.util.ArrayList;
import java.util.InputMismatchException;
import java.util.Scanner;

/**
 * This is the main class for the program TaskerCli, developed for
 * the CS22120 group project, by group 07.
 * 
 * This class is the centre of the program. It stores all of the 
 * tasks for the user and initialises the main components of the GUI.
 * The ‘main screen’ is supposed to provide a list of buttons, one
 * for each class, that once pressed interacts with the given task 
 * object and loads the task into the GUI. This class provides a 
 * reference to the ‘synchroniser’ so that when necessary, tasks can 
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
	//private LoginScreen loginScreen
	//private MainScreen mainScreen;
	
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
	 * 
	 * Currently initialises a command line interface for 
	 * prototype.
	 */
	public void initialiseLoginScreen(){
		Scanner in = new Scanner(System.in);
		//The input email address
		String userEmail;
		
		//Loop until a valid email address is entered
		while(synchroniser == null){
			System.out.println("Please enter you email: ");
			userEmail = in.nextLine();
			
			//Attempt to log in
			login(userEmail);
		}
		
		in.close();
	} 
	
	/**
	 * Initialises the GUI after the user has successfully
	 * logged in. 
	 * 
	 * Currently initialises a command line interface for 
	 * prototype.
	 */
	public void initialiseMainScreen(){
		Scanner in = new Scanner(System.in);
		//The task the user wants to view
		int chosenTask = -1;
		
		//If there are no tasks we can't proceed.
		if(tasks == null){
			return;
		}
		
		System.out.println("Welcome, here are your assigned tasks: ");
		//List each of the users tasks
		for(int i = 0; i < tasks.size(); i++){
			System.out.println("   Task " + i + ": " + tasks.get(i).getTitle());
		}
		
		//Ask the user to select a task.
		while(chosenTask == -1){
			System.out.println("Please enter the number of the task you want to view, or enter -2 to quit: ");
			try{
				chosenTask = in.nextInt();
			//Catch invalid input
			}catch (InputMismatchException e){
				//If the choice isnt valid we mist continue looping
				System.out.println("invalid input");
				in.next();
				chosenTask = -1;
			}
			
			//If the choice isnt valid
			if(chosenTask < 0 || chosenTask > tasks.size() - 1){
				//If they want to quit
				if(chosenTask == -2){
					System.exit(0);
				}else{
					//we must continue looping
					System.err.println("Invalid input");
					chosenTask = -1;
				}
			}
		}
		
		//Load the chosen task
		tasks.get(chosenTask).initialiseTaskPanel();
		in.close();
	}
	
	/**
	 * Called by pressing the ’log in’ button on the GUI. 
	 * Creates a new synchroniser with the input email.
	 * Attempts to load the relevant tasks from local storage
	 * and then synchronise them with the tasks on TaskerSvr.
	 * If successful the main screen GUI is loaded. If no
	 * tasks could be retrieved an error message is output
	 * and the user has to try a different email to continue.
	 * 
	 * @param userEmail
	 * 				The input email address.
	 */
	public void login(String userEmail){
		//Create a new synchroniser for this user so we can attempt to retrieve the data
		synchroniser = new Synchroniser(userEmail, this);
		//First try to load the local data, then attempt to synchronise with TaskerSvr
		tasks = synchroniser.retrieveTasksFromLocal();
		tasks = synchroniser.synchroniseTasks(tasks);
		
		/*If there were no tasks found... In future I want to catch a specific exception
		 * and flash an error message.*/
		if(tasks == null || tasks.size() == 0){
			//Null the synchroniser so we can start again.
			synchroniser = null;
			//Output error message
			System.err.println("Sorry but no data could be found, try a different email");
			System.out.println("");
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
	}
}
