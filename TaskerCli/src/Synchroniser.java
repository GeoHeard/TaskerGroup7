/**
 * 
 * Provides all of the loading, synchronising and saving 
 * functionality of the program.
 * 
 * @author Group 07: kuh1, ...
 * @version 0.1
 * @date 24/11/2015
 */
public class Synchroniser {
	
	private String employeeEmail;
	private TaskerCli tasker;
	
	/**
	 * Creates a new synchroniser for the input user.
	 * @param userEmail
	 * 				The email of the user logging in.
	 * @param mainProgram
	 * 				A reference to the main program.
	 */
	public Synchroniser(String userEmail, TaskerCli mainProgram){
		
	}
	
	/**
	 * Loads the relevant tasks (only those for the input user) from 
	 * local storage into an array of task objects. Should only really
	 * be called once per user.
	 * @return
	 * 		An array list of the tasks that are assigned to the input
	 * 		user, or null of no tasks found.
	 */
	public Task[] retrieveTasksFromLocal(){
		return null; 
	}
	
	/**
	 * Synchronises the input array of tasks with the tasks on taskerCli.
	 * Once a correct array of tasks has been produced it calls this.saveToLocal 
	 * and this.saveToSvr. If synchronisation failed only save to local.
	 *
	 * @param currentTasks
	 * 				The local copy of the users tasks.
	 * @return
	 * 				The new up to date version of the users task after 
	 * 				synchronisation, or the input list of tasks if the
	 * 				sever can't be contacted.
	 * 
	 * @throws NoTaskException: Email address found on TaskerSvr but no tasks
	 * 		stored locally or online
	 * @throws InvalidEmailException: No task or user data locally or online.
	 */
	public Task[] synchroniseTasks(Task[] currentTasks)/*throws ...*/{
		return null;
	}
	
	/**
	 * Saves the input list of tasks into local storage, overwriting what is 
	 * currently there.
	 * @param tasks
	 * 			The list of tasks to save.
	 */
	private void saveToLocal(Task[] tasks){
		
	}
	
	/**
	 * Saves the input list of tasks to TaskerSvr.
	 * @param tasks
	 * 			The list of tasks to save.
	 */
	private void saveToSvr(Task[] tasks){
		
	}
	
	/*
	private void invokeSynchronise(Task[] tasks)
	 */
}
